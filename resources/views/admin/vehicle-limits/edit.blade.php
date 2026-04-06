@extends('layouts.admin')
@section('title', 'Edit Vehicle Limit - Admin')
@section('page-title', 'Edit Vehicle Limit')

@section('content')
<div class="max-w-lg">
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8">
        <form method="POST" action="{{ route('admin.vehicle-limits.update', $vehicleLimit) }}" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label for="vehicle_type" class="block text-sm font-medium text-gray-300 mb-2">Vehicle Type</label>
                <input type="text" name="vehicle_type" id="vehicle_type" value="{{ old('vehicle_type', $vehicleLimit->vehicle_type) }}" required class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
                @error('vehicle_type') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="max_amount" class="block text-sm font-medium text-gray-300 mb-2">Max Amount (৳)</label>
                <input type="number" name="max_amount" id="max_amount" value="{{ old('max_amount', $vehicleLimit->max_amount) }}" required step="0.01" min="1" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
                <p class="mt-1 text-xs text-gray-500">এই vehicle type এ সর্বোচ্চ কত টাকার fuel নিতে পারবে</p>
                @error('max_amount') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>

            {{-- Liter Preview --}}
            <div class="bg-gray-800/40 border border-gray-700 rounded-xl p-4">
                <label for="preview_price" class="block text-sm font-medium text-gray-400 mb-2">Liter Preview (optional — for reference only)</label>
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <input type="number" id="preview_price" step="0.01" min="1" placeholder="Fuel price per liter" class="w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
                    </div>
                    <div class="text-gray-500">=</div>
                    <div class="flex-1 text-center">
                        <span id="liter_preview" class="text-lg font-bold text-emerald-400">0.00</span>
                        <span class="text-xs text-gray-500 ml-1">Liters</span>
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-600">এটা শুধু reference — DB তে save হবে না</p>
            </div>

            <div>
                <label for="block_days_per_amount" class="block text-sm font-medium text-gray-300 mb-2">Block Days per Max Amount</label>
                <input type="number" name="block_days_per_amount" id="block_days_per_amount" value="{{ old('block_days_per_amount', $vehicleLimit->block_days_per_amount) }}" required step="0.01" min="0.01" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
                <p class="mt-1 text-xs text-gray-500">Max Amount টাকা কিনলে কত দিন block হবে। Example: 1 = max amount টাকায় 1 দিন block</p>
                @error('block_days_per_amount') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>

            {{-- Block Days Preview --}}
            <div class="bg-amber-500/5 border border-amber-500/20 rounded-xl p-4">
                <p class="text-sm text-amber-400 font-medium mb-2">⏱️ Block Preview</p>
                <p class="text-xs text-gray-400">যদি কেউ <span id="preview_amount" class="text-white font-semibold">0</span> টাকার fuel কেনে → <span id="preview_block_days" class="text-amber-400 font-bold">0</span> দিন block থাকবে</p>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('admin.vehicle-limits.index') }}" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">Cancel</a>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all shadow-lg shadow-amber-500/25">Update Limit</button>
            </div>
        </form>
    </div>
</div>

<script>
    const maxAmountInput = document.getElementById('max_amount');
    const previewPriceInput = document.getElementById('preview_price');
    const literPreview = document.getElementById('liter_preview');
    const blockDaysInput = document.getElementById('block_days_per_amount');
    const previewAmount = document.getElementById('preview_amount');
    const previewBlockDays = document.getElementById('preview_block_days');

    function updateLiterPreview() {
        const maxAmount = parseFloat(maxAmountInput.value) || 0;
        const price = parseFloat(previewPriceInput.value) || 0;
        if (price > 0) {
            literPreview.textContent = (maxAmount / price).toFixed(2);
        } else {
            literPreview.textContent = '0.00';
        }
    }

    function updateBlockPreview() {
        const maxAmount = parseFloat(maxAmountInput.value) || 0;
        const blockDaysPerAmount = parseFloat(blockDaysInput.value) || 0;
        previewAmount.textContent = maxAmount;
        previewBlockDays.textContent = blockDaysPerAmount.toFixed(2);
    }

    maxAmountInput.addEventListener('input', () => { updateLiterPreview(); updateBlockPreview(); });
    previewPriceInput.addEventListener('input', updateLiterPreview);
    blockDaysInput.addEventListener('input', updateBlockPreview);

    updateLiterPreview();
    updateBlockPreview();
</script>
@endsection
