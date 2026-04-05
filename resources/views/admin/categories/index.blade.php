@extends('layouts.admin')
@section('title', 'Categories - Admin')
@section('page-title', 'Fuel Categories')
@section('page-description', 'Manage fuel categories')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.categories.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all shadow-lg shadow-amber-500/25 text-sm">
        + Add Category
    </a>
</div>

<div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="text-left py-4 px-6 text-gray-400 font-medium">ID</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Name</th>
                <th class="text-center py-4 px-6 text-gray-400 font-medium">Products</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Created</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr class="border-b border-gray-800/50 hover:bg-gray-800/30">
                    <td class="py-4 px-6 text-gray-300">{{ $category->id }}</td>
                    <td class="py-4 px-6 text-white font-semibold">{{ $category->name }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="px-3 py-1 bg-amber-500/10 text-amber-400 text-xs font-medium rounded-full">{{ $category->products_count }}</span>
                    </td>
                    <td class="py-4 px-6 text-gray-400">{{ $category->created_at->format('d M Y') }}</td>
                    <td class="py-4 px-6 text-right">
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 text-red-400 hover:bg-red-500/10 rounded-lg text-xs font-medium transition-all">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-400">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
