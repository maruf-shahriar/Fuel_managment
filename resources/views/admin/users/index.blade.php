@extends('layouts.admin')
@section('title', 'Users - Admin')
@section('page-title', 'Users')
@section('page-description', 'Manage registered users')

@section('content')
<div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="text-left py-4 px-6 text-gray-400 font-medium">ID</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Name</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Email</th>
                <th class="text-left py-4 px-6 text-gray-400 font-medium">Registered</th>
                <th class="text-right py-4 px-6 text-gray-400 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-b border-gray-800/50 hover:bg-gray-800/30">
                    <td class="py-4 px-6 text-gray-300">{{ $user->id }}</td>
                    <td class="py-4 px-6 text-white font-semibold">{{ $user->name }}</td>
                    <td class="py-4 px-6 text-gray-300">{{ $user->email }}</td>
                    <td class="py-4 px-6 text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="py-4 px-6 text-right">
                        <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 text-amber-400 hover:bg-amber-500/10 rounded-lg text-xs font-medium transition-all">Edit</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-8 text-center text-gray-400">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $users->links() }}</div>
@endsection
