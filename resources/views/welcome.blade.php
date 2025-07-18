@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-sky-50 to-blue-100">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Find Your Perfect
                    <span class="text-sky-600">Orthodontist</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Connect with qualified orthodontists for seamless treatment transfers. 
                    Continue your orthodontic journey with confidence.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register.patient.form') }}" 
                       class="btn-primary text-lg px-8 py-3">
                        Find Doctors Near You
                    </a>
                    <a href="{{ route('register.doctor.form') }}" 
                       class="bg-white text-sky-600 border-2 border-sky-600 hover:bg-sky-50 font-medium py-3 px-8 rounded-lg transition-colors text-lg">
                        Join as a Doctor
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    How OrthoTransfer Works
                </h2>
                <p class="text-xl text-gray-600">
                    Simple steps to find and connect with your new orthodontist
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="bg-sky-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Create Your Profile</h3>
                    <p class="text-gray-600">
                        Tell us about your current treatment, location preferences, and orthodontic needs.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="bg-sky-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Find Qualified Doctors</h3>
                    <p class="text-gray-600">
                        Browse verified orthodontists in your area who specialize in treatment transfers.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="bg-sky-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Connect & Transfer</h3>
                    <p class="text-gray-600">
                        Contact your chosen orthodontist and seamlessly transfer your treatment records.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-sky-600 mb-2">500+</div>
                    <div class="text-gray-600">Verified Orthodontists</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-sky-600 mb-2">1,200+</div>
                    <div class="text-gray-600">Successful Transfers</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-sky-600 mb-2">50+</div>
                    <div class="text-gray-600">Cities Covered</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-sky-600 mb-2">98%</div>
                    <div class="text-gray-600">Patient Satisfaction</div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 bg-sky-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Ready to Continue Your Orthodontic Journey?
            </h2>
            <p class="text-xl text-sky-100 mb-8">
                Join thousands of patients who have successfully transferred their treatment.
            </p>
            <a href="" 
               class="bg-white text-sky-600 hover:bg-gray-100 font-medium py-3 px-8 rounded-lg transition-colors text-lg">
                Get Started Today
            </a>
        </div>
    </div>
</div>
@endsection
