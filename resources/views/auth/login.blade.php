@extends('layouts.app')
@section('title', 'Login - Fuel Station')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-gray-900/80 backdrop-blur-xl border border-gray-800 rounded-2xl p-8 shadow-2xl">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/25">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Welcome Back</h2>
                <p class="text-gray-400 text-sm mt-1">Sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                                  focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500
                                  focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-emerald-500 focus:ring-emerald-500/50">
                    <label for="remember" class="ml-2 text-sm text-gray-400">Remember me</label>
                </div>

                <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-xl
                               hover:from-emerald-400 hover:to-cyan-400 transition-all shadow-lg shadow-emerald-500/25
                               hover:shadow-emerald-500/40 active:scale-[0.98]">
                    Sign In
                </button>
            </form>

            <p class="text-center text-sm text-gray-400 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300 font-medium transition-colors">Register</a>
            </p>
        </div>
    </div>
</div>
@endsection
