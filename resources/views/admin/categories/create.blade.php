@extends('layouts.admin')
@section('title', 'Add Category - Admin')
@section('page-title', 'Add Category')

@section('content')
<div class="max-w-lg">
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       placeholder="e.g., Octane"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">Cancel</a>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all shadow-lg shadow-amber-500/25">Create Category</button>
            </div>
        </form>
    </div>
</div>
@endsection
