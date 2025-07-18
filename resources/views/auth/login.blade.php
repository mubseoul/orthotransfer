@extends('layouts.app')

@section('content')
<div class="py-16">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg">
            <!-- Header -->
            <div class="bg-sky-600 text-white px-8 py-6 rounded-t-lg">
                <div class="text-center">
                    <h1 class="text-2xl font-bold">Sign In</h1>
                    <p class="mt-2 text-sky-100">Welcome back to OrthoTransfer</p>
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

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address *</label>
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
                        <button type="submit" class="btn-primary w-full py-3">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 