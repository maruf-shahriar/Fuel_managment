<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalSales = Purchase::where('status', 'paid')->sum('amount_paid');
        $totalTransactions = Purchase::count();
        $recentPurchases = Purchase::with(['user', 'product.category', 'vehicle'])
            ->latest()
            ->take(5)
            ->get();

        $products = Product::with('category')->get();
        $categories = Category::withCount('products')->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSales',
            'totalTransactions',
            'recentPurchases',
            'products',
            'categories'
        ));
    }
}
