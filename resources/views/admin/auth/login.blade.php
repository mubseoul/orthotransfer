@extends('admin.layouts.auth')

@section('title', 'Admin Login')

@section('heading', 'Welcome Back')
@section('subheading', 'Sign in to access the admin console')

@section('content')
<form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
    @csrf

    <div>
        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
            Email Address
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
            </div>
            <input id="email" 
                   name="email" 
                   type="email" 
                   autocomplete="email" 
                   required 
                   autofocus
                   value="{{ old('email') }}"
                   placeholder="admin@orthotransfer.com"
                   class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all duration-200 @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
        </div>
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
            Password
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <input id="password" 
                   name="password" 
                   type="password" 
                   autocomplete="current-password" 
                   required
                   placeholder="Enter your password"
                   class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all duration-200 @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
        </div>
        @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember" 
                   name="remember" 
                   type="checkbox" 
                   value="1"
                   {{ old('remember') ? 'checked' : '' }}
                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded transition-colors duration-200">
            <label for="remember" class="ml-3 block text-sm text-slate-700 font-medium">
                Remember me
            </label>
        </div>

        <div class="text-sm">
            <a href="#" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                Forgot password?
            </a>
        </div>
    </div>

    <div>
        <button type="submit" 
                class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </span>
            Sign In to Admin Console
        </button>
    </div>

    <!-- Security Notice -->
    <div class="mt-8 p-4 bg-amber-50 border border-amber-200 rounded-xl">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.722-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-amber-700">
                    <strong class="font-semibold">Security Notice:</strong> This is a restricted area for authorized administrators only. All access is logged and monitored.
                </p>
            </div>
        </div>
    </div>
</form>

<!-- Alternative Login -->
<div class="mt-8 text-center border-t border-slate-200 pt-6">
    <p class="text-sm text-slate-600 mb-3">
        Need to access the main site?
    </p>
    <a href="{{ route('login') }}" 
       class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-lg">
        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        User Login
    </a>
</div>
@endsection 