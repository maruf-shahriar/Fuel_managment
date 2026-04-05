@extends('layouts.admin')
@section('title', 'Products - Admin')
@section('page-title', 'Fuel Products')
@section('page-description', 'Manage fuel products, prices, and stock')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all shadow-lg shadow-amber-500/25 text-sm">
        + Add Product
    </a>
</div>

<div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Name</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Category</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Price/L</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Stock (L)</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr class="border-b border-gray-800/50 hover:bg-gray-800/30">
                    <td class="py-4 px-6 text-white font-semibold">{{ $product->name }}</td>
                    <td class="py-4 px-6"><span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-full">{{ $product->category->name }}</span></td>
                    <td class="py-4 px-6 text-right text-emerald-400 font-semibold">৳{{ number_format($product->price_per_liter, 2) }}</td>
                    <td class="py-4 px-6 text-right text-white">{{ number_format($product->available_quantity, 0) }}</td>
                    <td class="py-4 px-6 text-right space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="px-3 py-1.5 text-amber-400 hover:bg-amber-500/10 rounded-lg text-xs font-medium transition-all">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete this product?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 text-red-400 hover:bg-red-500/10 rounded-lg text-xs font-medium transition-all">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-8 text-center text-gray-400">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
