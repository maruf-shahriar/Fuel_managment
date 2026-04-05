@extends('layouts.admin')
@section('title', 'Dashboard - Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of fuel station operations')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Total Users</p>
                <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalUsers) }}</p>
            </div>
            <div class="w-12 h-12 bg-cyan-500/10 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Total Revenue</p>
                <p class="text-3xl font-bold text-emerald-400 mt-1">৳{{ number_format($totalSales, 2) }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Total Transactions</p>
                <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalTransactions) }}</p>
            </div>
            <div class="w-12 h-12 bg-violet-500/10 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- Stock Overview --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <h3 class="text-lg font-bold text-white mb-4">Fuel Stock</h3>
        <div class="space-y-4">
            @foreach($products as $product)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-white font-semibold">{{ number_format($product->available_quantity, 0) }} L</p>
                        <p class="text-xs text-gray-500">৳{{ number_format($product->price_per_liter, 2) }}/L</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
        <h3 class="text-lg font-bold text-white mb-4">Categories</h3>
        <div class="space-y-4">
            @foreach($categories as $category)
                <div class="flex items-center justify-between">
                    <span class="text-white font-medium">{{ $category->name }}</span>
                    <span class="px-3 py-1 bg-amber-500/10 text-amber-400 text-sm font-medium rounded-full">{{ $category->products_count }} products</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Recent Purchases --}}
<div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
    <h3 class="text-lg font-bold text-white mb-4">Recent Purchases</h3>
    @if($recentPurchases->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Slip ID</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">User</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Fuel</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Vehicle</th>
                        <th class="text-right py-3 px-4 text-gray-400 font-medium">Amount</th>
                        <th class="text-center py-3 px-4 text-gray-400 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPurchases as $purchase)
                        <tr class="border-b border-gray-800/50 hover:bg-gray-800/30">
                            <td class="py-3 px-4 text-white font-medium">{{ $purchase->slip_id }}</td>
                            <td class="py-3 px-4 text-gray-300">{{ $purchase->user->name }}</td>
                            <td class="py-3 px-4 text-gray-300">{{ $purchase->product->name }}</td>
                            <td class="py-3 px-4 text-gray-300">{{ $purchase->vehicle->vehicle_number }}</td>
                            <td class="py-3 px-4 text-right text-emerald-400 font-semibold">৳{{ number_format($purchase->amount_paid, 2) }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($purchase->status === 'paid') bg-emerald-500/10 text-emerald-400
                                    @elseif($purchase->status === 'collected') bg-cyan-500/10 text-cyan-400
                                    @else bg-yellow-500/10 text-yellow-400
                                    @endif">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-400 text-center py-8">No purchases yet.</p>
    @endif
</div>
@endsection
