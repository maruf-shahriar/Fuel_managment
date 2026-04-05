<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;

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
}
