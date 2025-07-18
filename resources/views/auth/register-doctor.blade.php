@extends('layouts.app')

@section('content')
<div class="py-16">
    <!-- New Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="lg:grid lg:grid-cols-2 lg:gap-0">
                <!-- Text Content -->
                <div class="px-8 py-12 lg:px-12 lg:py-16">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Join Our Network of Trusted Orthodontists</h1>
                    <p class="text-lg text-gray-600 mb-6">
                        Connect with patients who need to continue their orthodontic treatment. 
                        Expand your practice by accepting transfer patients and providing seamless care continuity.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-sky-100 text-sky-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Verified Patient Transfers</p>
                                <p class="text-sm text-gray-500">Access comprehensive treatment histories and records</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-sky-100 text-sky-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Practice Growth</p>
                                <p class="text-sm text-gray-500">Expand your patient base with quality referrals</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-sky-100 text-sky-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Professional Network</p>
                                <p class="text-sm text-gray-500">Connect with colleagues and share expertise</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Image Placeholder -->
                <div class="bg-gray-100 lg:aspect-square">
                    <div class="h-64 lg:h-full flex items-center justify-center">
                        <div class="text-center">
                            <svg class="h-20 w-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">Professional Doctor Image</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg">
            <!-- Header -->
            <div class="bg-sky-600 text-white px-8 py-6 rounded-t-lg">
                <div class="text-center">
                    <h2 class="text-2xl font-bold">Doctor Registration</h2>
                    <p class="mt-2 text-sky-100">Join OrthoTransfer to connect with patients seeking treatment transfers</p>
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

                <div class="alert-info mb-6">
                    <p><strong>Note:</strong> Doctor accounts require administrative approval before activation. You will receive an email notification once your account has been reviewed and approved.</p>
                </div>

                <form method="POST" action="{{ route('register.doctor') }}" class="space-y-6">
                    @csrf

                    <!-- Name Fields - Two Column Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-input" 
                               value="{{ old('email') }}" required>
                    </div>
                    
                    <!-- Password Fields - Two Column Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" id="password" name="password" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col space-y-3 pt-6">
                        <button type="submit" class="btn-primary w-full py-3">
                            Submit for Approval
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