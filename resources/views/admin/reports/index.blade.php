@extends('layouts.admin')
@section('title', 'Reports - Admin')
@section('page-title', 'Reports')
@section('page-description', 'Sales, revenue, and category-wise reports')

@section('content')
{{-- Date Filter --}}
<form method="GET" action="{{ route('admin.reports.index') }}" class="flex items-end gap-4 mb-8">
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">From</label>
        <input type="date" name="date_from" value="{{ $dateFrom }}" class="px-4 py-2.5 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">To</label>
        <input type="date" name="date_to" value="{{ $dateTo }}" class="px-4 py-2.5 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
    </div>
    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all text-sm">
        Filter
    </button>
</form>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <p class="text-sm text-gray-400">Total Revenue</p>
        <p class="text-3xl font-bold text-emerald-400 mt-1">৳{{ number_format($totalRevenue, 2) }}</p>
    </div>
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <p class="text-sm text-gray-400">Total Liters Sold</p>
        <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalLiters, 0) }} L</p>
    </div>
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <p class="text-sm text-gray-400">Total Transactions</p>
        <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalTransactions) }}</p>
    </div>
</div>

{{-- Category-wise Report --}}
<div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-gray-800">
        <h3 class="text-lg font-bold text-white">Category-wise Report</h3>
    </div>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Category</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Product</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Revenue</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Liters Sold</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryReport as $category)
                @foreach($category->products as $product)
                    <tr class="border-b border-gray-800/50 hover:bg-gray-800/30">
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-full">{{ $category->name }}</span>
                        </td>
                        <td class="py-4 px-6 text-white font-medium">{{ $product->name }}</td>
                        <td class="py-4 px-6 text-right text-emerald-400 font-semibold">৳{{ number_format($product->revenue ?? 0, 2) }}</td>
                        <td class="py-4 px-6 text-right text-white">{{ number_format($product->liters_sold ?? 0, 0) }} L</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
