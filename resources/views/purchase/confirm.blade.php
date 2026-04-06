@extends('layouts.app')
@section('title', 'Confirm Purchase - Fuel Station')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-2">Confirm Purchase</h1>
        <p class="text-gray-400 mb-8">Review your order and proceed to payment</p>

        <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">
            {{-- Order Summary --}}
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-between pb-6 border-b border-gray-800">
                    <div>
                        <p class="text-sm text-gray-400">Fuel</p>
                        <p class="text-lg font-bold text-white">{{ $product->name }}</p>
                        <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                    </div>
                    <p class="text-lg font-bold text-emerald-400">৳{{ number_format($product->price_per_liter, 2) }}/L</p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-400">Vehicle Type</p>
                        <p class="text-white font-semibold">{{ $vehicle_type }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Vehicle Number</p>
                        <p class="text-white font-semibold">{{ $vehicle_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Quantity</p>
                        <p class="text-white font-semibold">{{ $liters }} Liters</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Price per Liter</p>
                        <p class="text-white font-semibold">৳{{ number_format($product->price_per_liter, 2) }}</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-800">
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-bold text-white">Total Amount</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">
                            ৳{{ number_format($amount, 2) }}
                        </p>
                    </div>
                </div>

                {{-- Block Days Warning --}}
                @if($block_days > 0)
                <div class="bg-amber-500/10 border border-amber-500/30 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <span class="text-amber-400 text-xl">⚠️</span>
                        <div>
                            <p class="text-sm text-amber-400 font-semibold">Block Notice</p>
                            <p class="text-xs text-gray-400 mt-1">
                                এই purchase এর পর আপনি <span class="text-amber-400 font-bold">{{ $block_days }} দিন</span>
                                <span class="text-white font-semibold">{{ $vehicle_type }}</span> vehicle type এ আর fuel কিনতে পারবেন না।
                                অন্য vehicle type দিয়ে fuel কিনতে পারবেন।
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Payment --}}
            <div class="bg-gray-800/30 p-8 border-t border-gray-800">
                <form method="POST" action="{{ route('purchase.process') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="vehicle_type" value="{{ $vehicle_type }}">
                    <input type="hidden" name="vehicle_number" value="{{ $vehicle_number }}">
                    <input type="hidden" name="liters" value="{{ $liters }}">
                    <input type="hidden" name="amount" value="{{ $amount }}">

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-pink-500/10 rounded-xl flex items-center justify-center">
                            <span class="text-pink-400 font-bold text-lg">b</span>
                        </div>
                        <div>
                            <p class="text-white font-semibold">Pay with bKash</p>
                            <p class="text-sm text-gray-400">Mobile banking payment</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('purchase.select-fuel') }}" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">
                            Cancel
                        </a>
                        <button type="submit"
                                class="flex-1 py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-semibold rounded-xl
                                       hover:from-pink-400 hover:to-rose-400 transition-all shadow-lg shadow-pink-500/25
                                       hover:shadow-pink-500/40 active:scale-[0.98]">
                            Pay ৳{{ number_format($amount, 2) }} via bKash
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
