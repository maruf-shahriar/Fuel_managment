@extends('layouts.admin')
@section('title', 'Edit Product - Admin')
@section('page-title', 'Edit Product')

@section('content')
<div class="max-w-lg">
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                <select name="category_id" id="category_id" required class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Product Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
            </div>
            <div>
                <label for="price_per_liter" class="block text-sm font-medium text-gray-300 mb-2">Price per Liter (৳)</label>
                <input type="number" name="price_per_liter" id="price_per_liter" value="{{ old('price_per_liter', $product->price_per_liter) }}" required step="0.01" min="0.01" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
            </div>
            <div>
                <label for="available_quantity" class="block text-sm font-medium text-gray-300 mb-2">Available Quantity (Liters)</label>
                <input type="number" name="available_quantity" id="available_quantity" value="{{ old('available_quantity', $product->available_quantity) }}" required step="0.01" min="0" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">Cancel</a>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all shadow-lg shadow-amber-500/25">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
