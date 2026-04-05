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
     * Step 2: Enter vehicle info
     */
    public function vehicleInfo(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $product = Product::with('category')->findOrFail($request->product_id);
        $vehicleLimits = VehicleLimit::all();

        return view('purchase.vehicle-info', compact('product', 'vehicleLimits'));
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
            'liters' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $limit = VehicleLimit::where('vehicle_type', $validated['vehicle_type'])->first();

        // Check vehicle limit
        if ($limit) {
            if ($validated['liters'] > $limit->max_liters) {
                return back()->withErrors(['liters' => "Maximum {$limit->max_liters} liters allowed for {$validated['vehicle_type']}."])->withInput();
            }
            $totalAmount = $validated['liters'] * $product->price_per_liter;
            if ($totalAmount > $limit->max_amount) {
                return back()->withErrors(['liters' => "Maximum amount ৳{$limit->max_amount} exceeded for {$validated['vehicle_type']}."])->withInput();
            }
        }

        // Check stock
        if ($validated['liters'] > $product->available_quantity) {
            return back()->withErrors(['liters' => 'Insufficient fuel stock available.'])->withInput();
        }

        // Check if vehicle is blocked
        $existingVehicle = Vehicle::where('vehicle_number', $validated['vehicle_number'])->first();
        if ($existingVehicle && $existingVehicle->isCurrentlyBlocked()) {
            $blockedUntil = $existingVehicle->blocked_until->format('d M Y, h:i A');
            return back()->withErrors(['vehicle_number' => "This vehicle is blocked until {$blockedUntil}."])->withInput();
        }

        // Check duplicate vehicle type per user
        $user = auth()->user();
        if ($existingVehicle && $existingVehicle->user_id !== $user->id) {
            return back()->withErrors(['vehicle_number' => 'This vehicle is registered to another user.'])->withInput();
        }

        $amount = $validated['liters'] * $product->price_per_liter;

        return view('purchase.confirm', [
            'product' => $product,
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_number' => $validated['vehicle_number'],
            'liters' => $validated['liters'],
            'amount' => $amount,
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
            'liters' => 'required|numeric|min:1',
            'amount' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $user = auth()->user();

        // Find or create vehicle
        $vehicle = Vehicle::firstOrCreate(
            ['vehicle_number' => $validated['vehicle_number']],
            [
                'user_id' => $user->id,
                'vehicle_type' => $validated['vehicle_type'],
            ]
        );

        // Double-check vehicle is not blocked
        if ($vehicle->isCurrentlyBlocked()) {
            return redirect()->route('purchase.select-fuel')
                ->withErrors(['error' => 'Vehicle is currently blocked.']);
        }

        // Get block days from limits
        $limit = VehicleLimit::where('vehicle_type', $validated['vehicle_type'])->first();
        $blockDays = $limit ? $limit->block_days : 7;

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

        // Block vehicle
        $vehicle->update([
            'is_blocked' => true,
            'blocked_until' => now()->addDays($blockDays),
        ]);

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
