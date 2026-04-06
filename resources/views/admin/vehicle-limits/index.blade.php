@extends('layouts.admin')
@section('title', 'Vehicle Limits - Admin')
@section('page-title', 'Vehicle Limits')
@section('page-description', 'Manage purchase limits per vehicle type')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.vehicle-limits.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all shadow-lg shadow-amber-500/25 text-sm">
        + Add Vehicle Limit
    </a>
</div>

<div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Vehicle Type</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Max Amount (৳)</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Block Days / Max Amount</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($limits as $limit)
                <tr class="border-b border-gray-800/50 hover:bg-gray-800/30">
                    <td class="py-4 px-6 text-white font-semibold">{{ $limit->vehicle_type }}</td>
                    <td class="py-4 px-6 text-right text-emerald-400 font-semibold">৳{{ number_format($limit->max_amount, 2) }}</td>
                    <td class="py-4 px-6 text-right text-amber-400 font-semibold">{{ $limit->block_days_per_amount }} দিন</td>
                    <td class="py-4 px-6 text-right space-x-2">
                        <a href="{{ route('admin.vehicle-limits.edit', $limit) }}" class="px-3 py-1.5 text-amber-400 hover:bg-amber-500/10 rounded-lg text-xs font-medium transition-all">Edit</a>
                        <form method="POST" action="{{ route('admin.vehicle-limits.destroy', $limit) }}" class="inline" onsubmit="return confirm('Delete this limit?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 text-red-400 hover:bg-red-500/10 rounded-lg text-xs font-medium transition-all">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-8 text-center text-gray-400">No vehicle limits found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
