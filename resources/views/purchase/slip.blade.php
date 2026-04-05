@extends('layouts.app')
@section('title', 'Fuel Slip - Fuel Station')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-2xl mx-auto">
        {{-- Success Banner --}}
        <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-6 mb-8 text-center">
            <div class="w-16 h-16 bg-emerald-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-emerald-400">Payment Successful!</h2>
            <p class="text-gray-400 mt-1">Your fuel purchase has been confirmed</p>
        </div>

        {{-- Slip --}}
        <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden" id="fuel-slip">
            <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 p-6 text-center">
                <h3 class="text-2xl font-bold text-white">Fuel Purchase Slip</h3>
                <p class="text-emerald-100 text-sm mt-1">FuelStation Digital Slip</p>
            </div>

            <div class="p-8 space-y-6">
                <div class="text-center pb-6 border-b border-gray-800">
                    <p class="text-sm text-gray-400">Slip ID</p>
                    <p class="text-2xl font-bold text-white tracking-wider">{{ $purchase->slip_id }}</p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-400">Customer</p>
                        <p class="text-white font-semibold">{{ $purchase->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Email</p>
                        <p class="text-white font-semibold">{{ $purchase->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Fuel</p>
                        <p class="text-white font-semibold">{{ $purchase->product->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Category</p>
                        <p class="text-white font-semibold">{{ $purchase->product->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Vehicle Type</p>
                        <p class="text-white font-semibold">{{ $purchase->vehicle->vehicle_type }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Vehicle Number</p>
                        <p class="text-white font-semibold">{{ $purchase->vehicle->vehicle_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Quantity</p>
                        <p class="text-white font-semibold">{{ $purchase->liters }} Liters</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Amount Paid</p>
                        <p class="text-emerald-400 font-bold text-xl">৳{{ number_format($purchase->amount_paid, 2) }}</p>
                    </div>
                </div>

                @if($purchase->payment)
                <div class="pt-6 border-t border-gray-800">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-400">Transaction ID</p>
                            <p class="text-white font-semibold text-sm">{{ $purchase->payment->transaction_id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Payment Status</p>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-sm font-medium">
                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                {{ ucfirst($purchase->payment->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="pt-6 border-t border-gray-800">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-400">Status</p>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-cyan-500/10 text-cyan-400 rounded-full text-sm font-medium">
                                {{ ucfirst($purchase->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Date</p>
                            <p class="text-white font-semibold">{{ $purchase->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-4 mt-6">
            <a href="{{ route('purchase.download-slip', $purchase) }}"
               class="flex-1 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-xl
                      hover:from-emerald-400 hover:to-cyan-400 transition-all shadow-lg shadow-emerald-500/25 text-center">
                Download PDF
            </a>
            <button onclick="window.print()"
                    class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">
                Print
            </button>
            <a href="{{ route('purchase.history') }}"
               class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">
                History
            </a>
        </div>
    </div>
</div>
@endsection
