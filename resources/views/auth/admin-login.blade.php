@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-amber-50 to-yellow-100 py-16">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg">
            <!-- Header -->
            <div class="bg-amber-600 text-white px-8 py-6 rounded-t-lg">
                <div class="text-center">
                    <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold">Admin Login</h1>
                    <p class="mt-2 text-amber-100">Administrative Access Only</p>
                </div>
            </div>

            <!-- Form -->
            <div class="px-8 py-8">
                @if ($errors->any())
                    <div class="alert-danger mb-6">
                        <h4 class="font-medium mb-2">Please correct the following errors:</h4>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Admin Email Address *</label>
                        <input type="email" id="email" name="email" class="form-input" 
                               value="{{ old('email') }}" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" class="form-checkbox" value="1">
                            <label for="remember" class="ml-2 text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col space-y-3 pt-6">
                        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-3 px-4 rounded-lg transition-colors w-full">
                            Sign In to Admin Panel
                        </button>
                    </div>
                </form>

                <!-- Back to Main Site -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">Not an administrator?</p>
                        <a href="{{ route('login') }}" class="btn-outline w-full py-2 text-center">
                            Return to Main Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 