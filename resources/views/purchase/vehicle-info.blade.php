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

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-400">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('purchase.confirm') }}" class="space-y-6" id="vehicleForm">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div>
                <label for="vehicle_type" class="block text-sm font-medium text-gray-300 mb-2">Vehicle Type</label>
                <select name="vehicle_type" id="vehicle_type" required
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white
                               focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                    <option value="">Select Vehicle Type</option>
                    @foreach($vehicleLimits as $limit)
                        <option value="{{ $limit->vehicle_type }}"
                                data-max-amount="{{ $limit->max_amount }}"
                                data-block-days-per-amount="{{ $limit->block_days_per_amount }}"
                                {{ old('vehicle_type') === $limit->vehicle_type ? 'selected' : '' }}>
                            {{ $limit->vehicle_type }} (Max: ৳{{ number_format($limit->max_amount, 0) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Block Warning (shown if this vehicle type is currently blocked) --}}
            <div id="block_warning" class="hidden bg-red-500/10 border border-red-500/30 rounded-xl p-4">
                <p class="text-sm text-red-400 font-semibold">🚫 এই vehicle type blocked আছে</p>
                <p class="text-xs text-red-300 mt-1" id="block_warning_text"></p>
            </div>

            <div id="vehicle_number_section">
                <label for="vehicle_number" class="block text-sm font-medium text-gray-300 mb-2">Vehicle Number</label>
                <input type="text" name="vehicle_number" id="vehicle_number" value="{{ old('vehicle_number') }}" required
                       placeholder="e.g., Dhaka Metro-12-3456"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                              focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                <p class="mt-1 text-xs text-gray-500" id="vehicle_number_hint"></p>
            </div>

            <div>
                <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">Amount (৳)</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="1" step="1"
                       placeholder="কত টাকার fuel নিতে চান"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                              focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                <p class="mt-1 text-xs text-gray-500" id="max_amount_hint"></p>
            </div>

            {{-- Auto-calculated Liters --}}
            <div class="bg-gray-800/40 border border-gray-700 rounded-xl p-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Auto-calculated Liters</span>
                    <span class="text-2xl font-bold text-emerald-400" id="calculated-liters">0.00 L</span>
                </div>
            </div>

            {{-- Block Days Preview --}}
            <div id="block_preview" class="hidden bg-amber-500/5 border border-amber-500/20 rounded-xl p-4">
                <p class="text-sm text-amber-400 font-medium">⚠️ Block Notice</p>
                <p class="text-xs text-gray-400 mt-1">এই purchase করলে আপনি <span id="preview_block_days" class="text-amber-400 font-bold">0</span> দিন এই vehicle type এ আর fuel কিনতে পারবেন না।</p>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('purchase.select-fuel') }}" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">
                    Back
                </a>
                <button type="submit" id="submit_btn"
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
    const pricePerLiter = {{ $product->price_per_liter }};

    // User's existing vehicles (type -> {number, is_blocked, blocked_until})
    const userVehicles = @json($userVehicles);

    const vehicleTypeSelect = document.getElementById('vehicle_type');
    const vehicleNumberInput = document.getElementById('vehicle_number');
    const vehicleNumberHint = document.getElementById('vehicle_number_hint');
    const amountInput = document.getElementById('amount');
    const maxAmountHint = document.getElementById('max_amount_hint');
    const calculatedLiters = document.getElementById('calculated-liters');
    const blockWarning = document.getElementById('block_warning');
    const blockWarningText = document.getElementById('block_warning_text');
    const blockPreview = document.getElementById('block_preview');
    const previewBlockDays = document.getElementById('preview_block_days');
    const submitBtn = document.getElementById('submit_btn');

    vehicleTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        const selectedOption = this.options[this.selectedIndex];

        // Reset
        vehicleNumberInput.readOnly = false;
        vehicleNumberInput.value = '';
        vehicleNumberHint.textContent = '';
        blockWarning.classList.add('hidden');
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');

        if (!selectedType) {
            maxAmountHint.textContent = '';
            return;
        }

        // Show max amount hint
        const maxAmount = parseFloat(selectedOption.dataset.maxAmount) || 0;
        maxAmountHint.textContent = `সর্বোচ্চ ৳${maxAmount} টাকা পর্যন্ত নিতে পারবেন`;
        amountInput.max = maxAmount;

        // Check if user already has a vehicle of this type
        if (userVehicles[selectedType]) {
            const vehicle = userVehicles[selectedType];
            vehicleNumberInput.value = vehicle.vehicle_number;
            vehicleNumberInput.readOnly = true;
            vehicleNumberHint.textContent = '✅ আপনার আগের vehicle number automatically সেট হয়েছে';

            // Check if this vehicle type is blocked
            if (vehicle.is_blocked && vehicle.blocked_until) {
                const blockedUntil = new Date(vehicle.blocked_until);
                if (blockedUntil > new Date()) {
                    blockWarning.classList.remove('hidden');
                    blockWarningText.textContent = `${blockedUntil.toLocaleDateString('bn-BD')} ${blockedUntil.toLocaleTimeString('bn-BD')} পর্যন্ত block আছে। অন্য vehicle type দিয়ে fuel নিতে পারবেন।`;
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        updateCalculations();
    });

    amountInput.addEventListener('input', updateCalculations);

    function updateCalculations() {
        const amount = parseFloat(amountInput.value) || 0;
        const liters = amount / pricePerLiter;
        calculatedLiters.textContent = liters.toFixed(2) + ' L';

        // Block days preview
        const selectedOption = vehicleTypeSelect.options[vehicleTypeSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const maxAmount = parseFloat(selectedOption.dataset.maxAmount) || 0;
            const blockDaysPerAmount = parseFloat(selectedOption.dataset.blockDaysPerAmount) || 0;

            if (maxAmount > 0 && amount > 0) {
                const blockDays = (amount / maxAmount) * blockDaysPerAmount;
                previewBlockDays.textContent = blockDays.toFixed(2);
                blockPreview.classList.remove('hidden');
            } else {
                blockPreview.classList.add('hidden');
            }
        } else {
            blockPreview.classList.add('hidden');
        }
    }

    // Trigger on page load if old values exist
    if (vehicleTypeSelect.value) {
        vehicleTypeSelect.dispatchEvent(new Event('change'));
    }
</script>
@endsection
