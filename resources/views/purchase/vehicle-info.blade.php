@extends('layouts.app')
@section('title', 'Vehicle Information - Fuel Station')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-2">Vehicle Information</h1>
        <p class="text-gray-400 mb-8">Enter your vehicle details for <span class="text-emerald-400 font-semibold">{{ $product->name }}</span></p>

        {{-- Selected Fuel Info --}}
        <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Selected Fuel</p>
                    <p class="text-lg font-bold text-white">{{ $product->name }} ({{ $product->category->name }})</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-emerald-400">৳{{ number_format($product->price_per_liter, 2) }}</p>
                    <p class="text-xs text-gray-500">per liter</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('purchase.confirm') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div>
                <label for="vehicle_type" class="block text-sm font-medium text-gray-300 mb-2">Vehicle Type</label>
                <select name="vehicle_type" id="vehicle_type" required
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white
                               focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                    <option value="">Select Vehicle Type</option>
                    @foreach($vehicleLimits as $limit)
                        <option value="{{ $limit->vehicle_type }}" {{ old('vehicle_type') === $limit->vehicle_type ? 'selected' : '' }}>
                            {{ $limit->vehicle_type }} (Max: {{ $limit->max_liters }}L / ৳{{ number_format($limit->max_amount, 0) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="vehicle_number" class="block text-sm font-medium text-gray-300 mb-2">Vehicle Number</label>
                <input type="text" name="vehicle_number" id="vehicle_number" value="{{ old('vehicle_number') }}" required
                       placeholder="e.g., Dhaka Metro-12-3456"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                              focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
            </div>

            <div>
                <label for="liters" class="block text-sm font-medium text-gray-300 mb-2">Liters</label>
                <input type="number" name="liters" id="liters" value="{{ old('liters') }}" required min="1" step="0.5"
                       placeholder="Enter amount in liters"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                              focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
            </div>

            {{-- Estimated Cost --}}
            <div class="bg-gray-800/40 border border-gray-700 rounded-xl p-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Estimated Total</span>
                    <span class="text-2xl font-bold text-emerald-400" id="estimated-cost">৳0.00</span>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('purchase.select-fuel') }}" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">
                    Back
                </a>
                <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-xl
                               hover:from-emerald-400 hover:to-cyan-400 transition-all shadow-lg shadow-emerald-500/25
                               hover:shadow-emerald-500/40 active:scale-[0.98]">
                    Continue to Confirmation
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('liters').addEventListener('input', function() {
        const liters = parseFloat(this.value) || 0;
        const pricePerLiter = {{ $product->price_per_liter }};
        const total = liters * pricePerLiter;
        document.getElementById('estimated-cost').textContent = '৳' + total.toFixed(2);
    });
</script>
@endsection
