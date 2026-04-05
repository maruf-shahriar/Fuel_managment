@extends('layouts.admin')
@section('title', 'Purchase Details - Admin')
@section('page-title', 'Purchase Details')

@section('content')
<div class="max-w-2xl">
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8 space-y-6">
        <div class="flex items-center justify-between pb-6 border-b border-gray-800">
            <div>
                <p class="text-sm text-gray-400">Slip ID</p>
                <p class="text-2xl font-bold text-white">{{ $purchase->slip_id }}</p>
            </div>
            <span class="px-3 py-1.5 text-sm font-semibold rounded-full
                @if($purchase->status === 'paid') bg-emerald-500/10 text-emerald-400
                @elseif($purchase->status === 'collected') bg-cyan-500/10 text-cyan-400
                @else bg-yellow-500/10 text-yellow-400 @endif">
                {{ ucfirst($purchase->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div><p class="text-sm text-gray-400">Customer</p><p class="text-white font-semibold">{{ $purchase->user->name }}</p></div>
            <div><p class="text-sm text-gray-400">Email</p><p class="text-white font-semibold">{{ $purchase->user->email }}</p></div>
            <div><p class="text-sm text-gray-400">Fuel</p><p class="text-white font-semibold">{{ $purchase->product->name }} ({{ $purchase->product->category->name }})</p></div>
            <div><p class="text-sm text-gray-400">Liters</p><p class="text-white font-semibold">{{ $purchase->liters }} L</p></div>
            <div><p class="text-sm text-gray-400">Vehicle</p><p class="text-white font-semibold">{{ $purchase->vehicle->vehicle_type }} — {{ $purchase->vehicle->vehicle_number }}</p></div>
            <div><p class="text-sm text-gray-400">Amount Paid</p><p class="text-emerald-400 font-bold text-xl">৳{{ number_format($purchase->amount_paid, 2) }}</p></div>
            @if($purchase->payment)
                <div><p class="text-sm text-gray-400">Transaction ID</p><p class="text-white font-semibold text-sm">{{ $purchase->payment->transaction_id }}</p></div>
                <div><p class="text-sm text-gray-400">Payment Status</p><p class="text-emerald-400 font-semibold">{{ ucfirst($purchase->payment->payment_status) }}</p></div>
            @endif
            <div><p class="text-sm text-gray-400">Date</p><p class="text-white font-semibold">{{ $purchase->created_at->format('d M Y, h:i A') }}</p></div>
        </div>

        <div class="flex gap-4 pt-6 border-t border-gray-800">
            <a href="{{ route('admin.purchases.index') }}" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">Back</a>
            @if($purchase->status === 'paid')
                <form method="POST" action="{{ route('admin.purchases.collect', $purchase) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all shadow-lg shadow-amber-500/25">Mark as Collected</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
