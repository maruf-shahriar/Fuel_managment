<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['user', 'product.category', 'vehicle', 'payment'])
            ->latest()
            ->paginate(15);

        return view('admin.purchases.index', compact('purchases'));
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['user', 'product.category', 'vehicle', 'payment']);
        return view('admin.purchases.show', compact('purchase'));
    }

    public function markCollected(Purchase $purchase)
    {
        $purchase->update(['status' => 'collected']);
        return redirect()->back()->with('success', 'Purchase marked as collected.');
    }

    public function collectBySlipId(Request $request)
    {
        $request->validate(['slip_id' => 'required|string']);
        
        $purchase = Purchase::where('slip_id', $request->slip_id)->first();

        if (!$purchase) {
            return redirect()->back()->with('error', 'Purchase with this Slip ID not found.');
        }

        if ($purchase->status !== 'paid') {
            return redirect()->back()->with('error', 'Purchase is already ' . $purchase->status . '.');
        }

        $purchase->update(['status' => 'collected']);
        return redirect()->back()->with('success', 'Purchase marked as collected successfully.');
    }
}
