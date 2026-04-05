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
            </div>
            <div>
                <label for="max_amount" class="block text-sm font-medium text-gray-300 mb-2">Max Amount (৳)</label>
                <input type="number" name="max_amount" id="max_amount" value="{{ old('max_amount', $vehicleLimit->max_amount) }}" required step="0.01" min="0" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
            </div>
            <div>
                <label for="max_liters" class="block text-sm font-medium text-gray-300 mb-2">Max Liters</label>
                <input type="number" name="max_liters" id="max_liters" value="{{ old('max_liters', $vehicleLimit->max_liters) }}" required step="0.01" min="0" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
            </div>
            <div>
                <label for="block_days" class="block text-sm font-medium text-gray-300 mb-2">Block Days</label>
                <input type="number" name="block_days" id="block_days" value="{{ old('block_days', $vehicleLimit->block_days) }}" required min="1" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.vehicle-limits.index') }}" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">Cancel</a>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all shadow-lg shadow-amber-500/25">Update Limit</button>
            </div>
        </form>
    </div>
</div>
@endsection
