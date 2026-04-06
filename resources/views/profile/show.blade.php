@extends('layouts.app')
@section('title', 'My Profile - Fuel Station')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-white mb-2">My Profile</h1>
    <p class="text-gray-400 mb-8">আপনার একাউন্ট এবং সমস্ত তথ্য দেখুন ও আপডেট করুন</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Stats & Vehicles --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- User Stats Card --}}
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                        <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-400">{{ $user->email }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full {{ $user->role === 'admin' ? 'bg-amber-500/10 text-amber-400' : 'bg-emerald-500/10 text-emerald-400' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-gray-800/50 rounded-xl p-3 text-center">
                        <p class="text-xl font-bold text-emerald-400">{{ $totalPurchases }}</p>
                        <p class="text-xs text-gray-500 mt-1">Purchases</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-xl p-3 text-center">
                        <p class="text-xl font-bold text-cyan-400">৳{{ number_format($totalSpent, 0) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total Spent</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-xl p-3 text-center">
                        <p class="text-xl font-bold text-amber-400">{{ number_format($totalLiters, 1) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Liters</p>
                    </div>
                </div>
            </div>

            {{-- My Vehicles --}}
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-4">🚗 My Vehicles</h3>
                @if($vehicles->count() > 0)
                    <div class="space-y-3">
                        @foreach($vehicles as $vehicle)
                            <div class="bg-gray-800/40 rounded-xl p-4 border border-gray-700/50">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-white font-semibold">{{ $vehicle->vehicle_type }}</span>
                                    @if($vehicle->currently_blocked)
                                        <span class="px-2 py-0.5 text-xs font-medium bg-red-500/10 text-red-400 rounded-full">🔒 Blocked</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs font-medium bg-emerald-500/10 text-emerald-400 rounded-full">✅ Active</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-400">{{ $vehicle->vehicle_number }}</p>
                                @if($vehicle->currently_blocked && $vehicle->blocked_until)
                                    <p class="text-xs text-red-300 mt-2">
                                        Unblock: {{ $vehicle->blocked_until->format('d M Y, h:i A') }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">কোনো vehicle registered নেই। Fuel কিনলে automatically add হবে।</p>
                @endif
            </div>

            {{-- Account Info --}}
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-4">📋 Account Info</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Member Since</span>
                        <span class="text-white">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Email</span>
                        <span class="text-white">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Mobile</span>
                        <span class="text-white">{{ $user->mobile_number ?? 'Not Set' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Role</span>
                        <span class="text-white">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Total Vehicles</span>
                        <span class="text-white">{{ $vehicles->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Edit Forms --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Update Profile --}}
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8">
                <h3 class="text-lg font-bold text-white mb-6">✏️ Update Profile</h3>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                                      focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                        @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email (Cannot be changed)</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" disabled
                               class="w-full px-4 py-3 bg-gray-800/20 border border-gray-700/50 rounded-xl text-gray-500 cursor-not-allowed transition-all">
                    </div>
                    <div>
                        <label for="mobile_number" class="block text-sm font-medium text-gray-300 mb-2">Mobile Number</label>
                        <input type="text" name="mobile_number" id="mobile_number" value="{{ old('mobile_number', $user->mobile_number) }}" required
                               class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                                      focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                        @error('mobile_number') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-xl
                                   hover:from-emerald-400 hover:to-cyan-400 transition-all shadow-lg shadow-emerald-500/25
                                   hover:shadow-emerald-500/40 active:scale-[0.98]">
                        Update Profile
                    </button>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8">
                <h3 class="text-lg font-bold text-white mb-6">🔒 Change Password</h3>
                <form method="POST" action="{{ route('profile.update-password') }}" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Current Password</label>
                        <input type="password" name="current_password" id="current_password" required
                               class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                                      focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                        @error('current_password') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                                      focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                        @error('password') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                                      focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                    </div>
                    <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-violet-500 to-purple-500 text-white font-semibold rounded-xl
                                   hover:from-violet-400 hover:to-purple-400 transition-all shadow-lg shadow-violet-500/25
                                   hover:shadow-violet-500/40 active:scale-[0.98]">
                        Change Password
                    </button>
                </form>
            </div>

            {{-- Recent Purchases --}}
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-white">🧾 Recent Purchases</h3>
                    <a href="{{ route('purchase.history') }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-all">View All →</a>
                </div>
                @if($user->purchases->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->purchases->take(5) as $purchase)
                            <div class="bg-gray-800/40 rounded-xl p-4 border border-gray-700/50 flex items-center justify-between">
                                <div>
                                    <p class="text-white font-semibold text-sm">{{ $purchase->product->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $purchase->vehicle->vehicle_type ?? '' }} • {{ $purchase->vehicle->vehicle_number ?? '' }}</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $purchase->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-emerald-400 font-bold">৳{{ number_format($purchase->amount_paid, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $purchase->liters }}L</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">এখনো কোনো purchase করা হয়নি।</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
