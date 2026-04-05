@extends('layouts.admin')
@section('title', 'Edit User - Admin')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-lg">
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">Cancel</a>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-400 transition-all shadow-lg shadow-amber-500/25">Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection
