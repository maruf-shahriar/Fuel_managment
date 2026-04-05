@extends('layouts.app')
@section('title', 'Select Fuel - Fuel Station')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-2">Select Fuel</h1>
        <p class="text-gray-400 mb-8">Choose the fuel type you want to purchase</p>

        <div class="space-y-4">
            @forelse($products as $product)
                <form method="POST" action="{{ route('purchase.vehicle-info') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="w-full bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6 hover:border-emerald-500/40 transition-all text-left group hover:-translate-y-0.5
                                                  {{ $product->available_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $product->available_quantity <= 0 ? 'disabled' : '' }}>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center group-hover:bg-emerald-500/20 transition-colors">
                                    <svg class="w-7 h-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-400">{{ $product->category->name }} • {{ number_format($product->available_quantity, 0) }} L available</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">৳{{ number_format($product->price_per_liter, 2) }}</p>
                                <p class="text-xs text-gray-500">per liter</p>
                            </div>
                        </div>
                    </button>
                </form>
            @empty
                <div class="text-center py-16 bg-gray-900/60 rounded-2xl border border-gray-800">
                    <p class="text-gray-400 text-lg">No fuel available at the moment.</p>
                    <a href="{{ route('home') }}" class="inline-block mt-4 text-emerald-400 hover:text-emerald-300">Go back home</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
