@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar -->
        <x-dashboard-sidebar />

        <!-- Main Content -->
        <div class="flex-1">
            <div class="space-y-8">
                <!-- Welcome Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ $user->first_name }}!</h1>
                            <p class="text-gray-600 mt-2">
                                @if($user->isPatient())
                                    Patient Dashboard - Find and connect with orthodontists
                                @elseif($user->isDoctor())
                                    Doctor Dashboard - Manage your practice and patient connections
                                @else
                                    Dashboard - Manage your OrthoTransfer profile
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</div>
                            <div class="text-2xl font-bold text-gray-900">{{ now()->format('g:i A') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Profile Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-sky-100 rounded-xl flex items-center justify-center">
                                <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Profile</h3>
                                <p class="text-gray-600 text-sm">Manage your personal information</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('dashboard.profile') }}" 
                               class="inline-flex items-center text-sky-600 hover:text-sky-700 font-medium text-sm">
                                Update Profile
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Addresses Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Addresses</h3>
                                <p class="text-gray-600 text-sm">Manage your locations</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('dashboard.addresses') }}" 
                               class="inline-flex items-center text-sky-600 hover:text-sky-700 font-medium text-sm">
                                Manage Addresses
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    @if($user->isPatient())
                    <!-- Find Doctors Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Find Doctors</h3>
                                <p class="text-gray-600 text-sm">Search for orthodontists near you</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="#" 
                               class="inline-flex items-center text-sky-600 hover:text-sky-700 font-medium text-sm">
                                Search Now
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 