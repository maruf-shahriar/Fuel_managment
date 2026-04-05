<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->get('date_to', now()->toDateString());

        $totalRevenue = Purchase::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->sum('amount_paid');

        $totalLiters = Purchase::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->sum('liters');

        $totalTransactions = Purchase::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->count();

        // Category-wise report
        $categoryReport = Category::withCount(['products as total_purchases' => function ($query) use ($dateFrom, $dateTo) {
            $query->whereHas('purchases', function ($q) use ($dateFrom, $dateTo) {
                $q->where('status', '!=', 'cancelled')
                    ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59']);
            });
        }])
        ->with(['products' => function ($query) use ($dateFrom, $dateTo) {
            $query->withSum(['purchases as revenue' => function ($q) use ($dateFrom, $dateTo) {
                $q->where('status', '!=', 'cancelled')
                    ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59']);
            }], 'amount_paid')
            ->withSum(['purchases as liters_sold' => function ($q) use ($dateFrom, $dateTo) {
                $q->where('status', '!=', 'cancelled')
                    ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59']);
            }], 'liters');
        }])
        ->get();

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalLiters',
            'totalTransactions',
            'categoryReport',
            'dateFrom',
            'dateTo'
        ));
    }
}
