@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-sky-50 to-blue-100 py-16">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg">
            <!-- Header -->
            <div class="bg-sky-600 text-white px-8 py-6 rounded-t-lg">
                <div class="text-center">
                    <h1 class="text-2xl font-bold">Patient Registration</h1>
                    <p class="mt-2 text-sky-100">Join OrthoTransfer to find your perfect orthodontist</p>
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

                <form method="POST" action="{{ route('register.patient') }}" class="space-y-6">
                    @csrf

                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" id="first_name" name="first_name" class="form-input" 
                               value="{{ old('first_name') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" class="form-input" 
                               value="{{ old('last_name') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-input" 
                               value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col space-y-3 pt-6">
                        <button type="submit" class="btn-primary w-full py-3">
                            Create Patient Account
                        </button>
                        <a href="{{ route('home') }}" class="btn-secondary w-full py-3 text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 