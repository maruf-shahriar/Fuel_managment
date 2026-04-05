@extends('layouts.app')
@section('title', 'Purchase History - Fuel Station')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-white mb-2">Purchase History</h1>
    <p class="text-gray-400 mb-8">All your fuel purchases</p>

    @if($purchases->count() > 0)
        <div class="space-y-4">
            @foreach($purchases as $purchase)
                <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6 hover:border-gray-700 transition-all">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-bold">{{ $purchase->product->name }}</p>
                                <p class="text-sm text-gray-400">{{ $purchase->vehicle->vehicle_type }} • {{ $purchase->vehicle->vehicle_number }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $purchase->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-right">
                                <p class="text-lg font-bold text-emerald-400">৳{{ number_format($purchase->amount_paid, 2) }}</p>
                                <p class="text-xs text-gray-500">{{ $purchase->liters }}L</p>
                            </div>

                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($purchase->status === 'paid') bg-emerald-500/10 text-emerald-400
                                @elseif($purchase->status === 'collected') bg-cyan-500/10 text-cyan-400
                                @elseif($purchase->status === 'cancelled') bg-red-500/10 text-red-400
                                @else bg-yellow-500/10 text-yellow-400
                                @endif">
                                {{ ucfirst($purchase->status) }}
                            </span>

                            <div class="flex gap-2">
                                <a href="{{ route('purchase.slip', $purchase) }}" class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-all border border-gray-700">View</a>
                                <a href="{{ route('purchase.download-slip', $purchase) }}" class="px-4 py-2 bg-emerald-500/10 text-emerald-400 text-sm font-medium rounded-lg hover:bg-emerald-500/20 transition-all">PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $purchases->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-gray-900/60 rounded-2xl border border-gray-800">
            <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-gray-400 text-lg">No purchases yet</p>
            <a href="{{ route('purchase.select-fuel') }}"
               class="inline-block mt-4 px-6 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-xl hover:from-emerald-400 hover:to-cyan-400 transition-all">
                Buy Fuel Now
            </a>
        </div>
    @endif
</div>
@endsection
