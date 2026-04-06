<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Vehicle;
use App\Models\VehicleLimit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    /**
     * Step 1: Select fuel product
     */
    public function selectFuel()
    {
        $products = Product::with('category')->where('available_quantity', '>', 0)->get();
        return view('purchase.select-fuel', compact('products'));
    }

    /**
     * Step 2: Enter vehicle info & amount
     */
    public function vehicleInfo(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $product = Product::with('category')->findOrFail($request->product_id);
        $vehicleLimits = VehicleLimit::all();

        $user = auth()->user();
        // Get user's existing vehicles grouped by type
        $userVehicles = Vehicle::where('user_id', $user->id)->get()->keyBy('vehicle_type');

        return view('purchase.vehicle-info', compact('product', 'vehicleLimits', 'userVehicles'));
    }

    /**
     * Step 3: Validate limits and show confirmation
     */
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'vehicle_type' => 'required|string',
            'vehicle_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $limit = VehicleLimit::where('vehicle_type', $validated['vehicle_type'])->first();
        $user = auth()->user();

        // Check if this vehicle type is blocked for this user
        $existingVehicle = Vehicle::where('user_id', $user->id)
            ->where('vehicle_type', $validated['vehicle_type'])
            ->first();

        if ($existingVehicle && $existingVehicle->isCurrentlyBlocked()) {
            $blockedUntil = $existingVehicle->blocked_until->format('d M Y, h:i A');
            return back()->withErrors(['vehicle_type' => "এই vehicle type ({$validated['vehicle_type']}) blocked আছে {$blockedUntil} পর্যন্ত।"])->withInput();
        }

        // One vehicle per type per user — check if user already has a DIFFERENT vehicle number for this type
        if ($existingVehicle && $existingVehicle->vehicle_number !== $validated['vehicle_number']) {
            return back()->withErrors(['vehicle_number' => "আপনার এই vehicle type এ already একটি vehicle ({$existingVehicle->vehicle_number}) registered আছে। একই type এ দুইটি vehicle add করা যাবে না।"])->withInput();
        }

        // Check if this vehicle number belongs to another user
        $otherUserVehicle = Vehicle::where('vehicle_number', $validated['vehicle_number'])
            ->where('user_id', '!=', $user->id)
            ->first();
        if ($otherUserVehicle) {
            return back()->withErrors(['vehicle_number' => 'এই vehicle number অন্য user এর নামে registered।'])->withInput();
        }

        // Check vehicle limit (max amount)
        if ($limit && $validated['amount'] > $limit->max_amount) {
            return back()->withErrors(['amount' => "সর্বোচ্চ ৳{$limit->max_amount} টাকার fuel নিতে পারবেন {$validated['vehicle_type']} এর জন্য।"])->withInput();
        }

        // Calculate liters from amount
        $liters = $validated['amount'] / $product->price_per_liter;

        // Check stock
        if ($liters > $product->available_quantity) {
            return back()->withErrors(['amount' => 'পর্যাপ্ত fuel stock নেই।'])->withInput();
        }

        // Calculate block days for preview
        $blockDays = 0;
        if ($limit) {
            $blockDays = $limit->calculateBlockDays($validated['amount']);
        }

        return view('purchase.confirm', [
            'product' => $product,
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_number' => $validated['vehicle_number'],
            'liters' => round($liters, 2),
            'amount' => $validated['amount'],
            'block_days' => round($blockDays, 2),
        ]);
    }

    /**
     * Step 4: Process payment (bKash stub) and generate slip
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'vehicle_type' => 'required|string',
            'vehicle_number' => 'required|string',
            'liters' => 'required|numeric|min:0.01',
            'amount' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $user = auth()->user();

        // Find or create vehicle
        $vehicle = Vehicle::firstOrCreate(
            [
                'user_id' => $user->id,
                'vehicle_type' => $validated['vehicle_type'],
            ],
            [
                'vehicle_number' => $validated['vehicle_number'],
            ]
        );

        // Double-check vehicle is not blocked
        if ($vehicle->isCurrentlyBlocked()) {
            return redirect()->route('purchase.select-fuel')
                ->withErrors(['error' => 'এই vehicle type এখন blocked আছে।']);
        }

        // Calculate block days dynamically from amount
        $limit = VehicleLimit::where('vehicle_type', $validated['vehicle_type'])->first();
        $blockDays = $limit ? $limit->calculateBlockDays($validated['amount']) : 0;

        // Generate unique slip ID
        $slipId = 'FS-' . strtoupper(Str::random(8));

        // Create purchase
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'product_id' => $product->id,
            'amount_paid' => $validated['amount'],
            'liters' => $validated['liters'],
            'status' => 'paid',
            'slip_id' => $slipId,
        ]);

        // Create payment (bKash stub)
        Payment::create([
            'purchase_id' => $purchase->id,
            'transaction_id' => 'BKASH-' . strtoupper(Str::random(10)),
            'payment_status' => 'completed',
        ]);

        // Deduct stock
        $product->decrement('available_quantity', $validated['liters']);

        // Block this specific vehicle based on calculated days
        if ($blockDays > 0) {
            // Convert decimal days to hours for precision
            $blockHours = $blockDays * 24;
            $vehicle->update([
                'is_blocked' => true,
                'blocked_until' => now()->addHours(round($blockHours)),
            ]);
        }

        return redirect()->route('purchase.slip', $purchase->id);
    }

    /**
     * View slip
     */
    public function slip(Purchase $purchase)
    {
        $this->authorizePurchase($purchase);
        $purchase->load(['user', 'vehicle', 'product.category', 'payment']);

        return view('purchase.slip', compact('purchase'));
    }

    /**
     * Download slip as PDF
     */
    public function downloadSlip(Purchase $purchase)
    {
        $this->authorizePurchase($purchase);
        $purchase->load(['user', 'vehicle', 'product.category', 'payment']);

        $pdf = Pdf::loadView('purchase.slip-pdf', compact('purchase'));
        return $pdf->download("fuel-slip-{$purchase->slip_id}.pdf");
    }

    /**
     * Purchase history
     */
    public function history()
    {
        $purchases = auth()->user()->purchases()
            ->with(['product.category', 'vehicle', 'payment'])
            ->latest()
            ->paginate(10);

        return view('purchase.history', compact('purchases'));
    }

    private function authorizePurchase(Purchase $purchase): void
    {
        if ($purchase->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}
