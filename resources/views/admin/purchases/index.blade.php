@extends('layouts.admin')
@section('title', 'Purchases - Admin')
@section('page-title', 'Purchases')
@section('page-description', 'View and manage all purchase transactions')

@section('content')
<div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Slip ID</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">User</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Fuel</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Vehicle</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Liters</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Amount</th>
                <th class="text-center py-4 px-6 text-gray-400 font-medium">Status</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchases as $purchase)
                <tr class="border-b border-gray-800/50 hover:bg-gray-800/30">
                    <td class="py-4 px-6 text-white font-medium">{{ $purchase->slip_id }}</td>
                    <td class="py-4 px-6 text-gray-300">{{ $purchase->user->name }}</td>
                    <td class="py-4 px-6 text-gray-300">{{ $purchase->product->name }}</td>
                    <td class="py-4 px-6 text-gray-300">{{ $purchase->vehicle->vehicle_number }}</td>
                    <td class="py-4 px-6 text-right text-white">{{ $purchase->liters }}</td>
                    <td class="py-4 px-6 text-right text-emerald-400 font-semibold">৳{{ number_format($purchase->amount_paid, 2) }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($purchase->status === 'paid') bg-emerald-500/10 text-emerald-400
                            @elseif($purchase->status === 'collected') bg-cyan-500/10 text-cyan-400
                            @elseif($purchase->status === 'cancelled') bg-red-500/10 text-red-400
                            @else bg-yellow-500/10 text-yellow-400
                            @endif">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right space-x-1">
                        <a href="{{ route('admin.purchases.show', $purchase) }}" class="px-3 py-1.5 text-cyan-400 hover:bg-cyan-500/10 rounded-lg text-xs font-medium transition-all">View</a>
                        @if($purchase->status === 'paid')
                            <form method="POST" action="{{ route('admin.purchases.collect', $purchase) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 text-amber-400 hover:bg-amber-500/10 rounded-lg text-xs font-medium transition-all">Collect</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="py-8 text-center text-gray-400">No purchases found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $purchases->links() }}</div>
@endsection
