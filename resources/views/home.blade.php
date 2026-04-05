@extends('layouts.app')
@section('title', 'Fuel Station - Pre-Purchase Fuel Online')

@section('content')
{{-- Hero Section --}}
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 via-transparent to-cyan-500/10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500/10 border border-emerald-500/30 rounded-full text-emerald-400 text-sm font-medium mb-6">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                Available Now
            </div>
            <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight">
                Pre-Purchase
                <span class="bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent"> Fuel Online</span>
            </h1>
            <p class="text-xl text-gray-400 mt-6 leading-relaxed">
                Skip the queue. Buy fuel online, get a digital slip, and redeem it at the station. Fast, secure, and convenient.
            </p>
            <div class="flex items-center justify-center gap-4 mt-10">
                @auth
                    <a href="{{ route('purchase.select-fuel') }}"
                       class="px-8 py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-xl
                              hover:from-emerald-400 hover:to-cyan-400 transition-all shadow-lg shadow-emerald-500/25
                              hover:shadow-emerald-500/40 text-lg active:scale-[0.98]">
                        Buy Fuel Now
                    </a>
                    <a href="{{ route('purchase.history') }}"
                       class="px-8 py-4 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700 text-lg">
                        View History
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="px-8 py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-xl
                              hover:from-emerald-400 hover:to-cyan-400 transition-all shadow-lg shadow-emerald-500/25
                              hover:shadow-emerald-500/40 text-lg active:scale-[0.98]">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}"
                       class="px-8 py-4 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700 text-lg">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

{{-- How It Works --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-white text-center mb-12">How It Works</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Step 1 --}}
        <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8 hover:border-emerald-500/50 transition-all group hover:-translate-y-1">
            <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-500/20 transition-colors">
                <svg class="w-7 h-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                </svg>
            </div>
            <div class="text-xs font-bold text-emerald-400 uppercase tracking-wider mb-2">Step 1</div>
            <h3 class="text-xl font-bold text-white mb-3">Select Fuel</h3>
            <p class="text-gray-400 leading-relaxed">Choose your fuel type and enter the amount you need.</p>
        </div>

        {{-- Step 2 --}}
        <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8 hover:border-cyan-500/50 transition-all group hover:-translate-y-1">
            <div class="w-14 h-14 bg-cyan-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-cyan-500/20 transition-colors">
                <svg class="w-7 h-7 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="text-xs font-bold text-cyan-400 uppercase tracking-wider mb-2">Step 2</div>
            <h3 class="text-xl font-bold text-white mb-3">Pay via bKash</h3>
            <p class="text-gray-400 leading-relaxed">Complete payment securely through bKash mobile banking.</p>
        </div>

        {{-- Step 3 --}}
        <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8 hover:border-violet-500/50 transition-all group hover:-translate-y-1">
            <div class="w-14 h-14 bg-violet-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-violet-500/20 transition-colors">
                <svg class="w-7 h-7 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="text-xs font-bold text-violet-400 uppercase tracking-wider mb-2">Step 3</div>
            <h3 class="text-xl font-bold text-white mb-3">Get Your Slip</h3>
            <p class="text-gray-400 leading-relaxed">Download or print your digital slip and redeem at the station.</p>
        </div>
    </div>
</section>

{{-- Fuel Availability --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-white text-center mb-4">Fuel Availability</h2>
    <p class="text-gray-400 text-center mb-12">Current stock and pricing information</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($products as $product)
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden hover:border-emerald-500/30 transition-all hover:-translate-y-1 group">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-semibold rounded-full uppercase tracking-wider">
                            {{ $product->category->name }}
                        </span>
                        @if($product->available_quantity > 0)
                            <span class="flex items-center gap-1.5 text-emerald-400 text-sm">
                                <span class="w-2 h-2 bg-emerald-400 rounded-full"></span> In Stock
                            </span>
                        @else
                            <span class="flex items-center gap-1.5 text-red-400 text-sm">
                                <span class="w-2 h-2 bg-red-400 rounded-full"></span> Out of Stock
                            </span>
                        @endif
                    </div>

                    <h3 class="text-2xl font-bold text-white mb-2">{{ $product->name }}</h3>

                    <div class="flex items-baseline gap-1 mb-4">
                        <span class="text-4xl font-extrabold bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">৳{{ number_format($product->price_per_liter, 2) }}</span>
                        <span class="text-gray-500 text-sm">/liter</span>
                    </div>

                    <div class="bg-gray-800/50 rounded-xl p-4 mb-6">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">Available</span>
                            <span class="text-white font-semibold">{{ number_format($product->available_quantity, 0) }} L</span>
                        </div>
                        <div class="mt-3 w-full bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 h-2 rounded-full transition-all" style="width: {{ min(($product->available_quantity / 10000) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    @auth
                        @if($product->available_quantity > 0)
                            <form method="POST" action="{{ route('purchase.vehicle-info') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="w-full py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-xl
                                           hover:from-emerald-400 hover:to-cyan-400 transition-all shadow-lg shadow-emerald-500/25
                                           hover:shadow-emerald-500/40 active:scale-[0.98]">
                                    Purchase Now
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full py-3 bg-gray-800 text-gray-500 font-semibold rounded-xl cursor-not-allowed">
                                Out of Stock
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all text-center border border-gray-700">
                            Login to Purchase
                        </a>
                    @endauth
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-400">No fuel products available at the moment.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
