@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Welcome back, {{ $user->first_name }}!
                        </h1>
                        <p class="text-gray-600 mt-1">
                            @if($user->isPatient())
                                Patient Dashboard - Find and connect with orthodontists
                            @elseif($user->isDoctor())
                                Doctor Dashboard - Manage your practice and patient connections
                            @else
                                Admin Dashboard - Manage the OrthoTransfer platform
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="h-12 w-12 bg-sky-500 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $user->full_name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ $user->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if($user->isPatient())
                <!-- Patient Dashboard Cards -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-sky-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Find Doctors</h3>
                            <p class="text-sm text-gray-500">Search for orthodontists in your area</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-primary w-full">
                            Search Doctors
                        </button>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">My Profile</h3>
                            <p class="text-sm text-gray-500">Complete your patient profile</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-secondary w-full">
                            Update Profile
                        </button>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Messages</h3>
                            <p class="text-sm text-gray-500">Chat with doctors</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-secondary w-full">
                            View Messages
                        </button>
                    </div>
                </div>

            @elseif($user->isDoctor())
                <!-- Doctor Dashboard Cards -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-sky-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Patient Inquiries</h3>
                            <p class="text-sm text-gray-500">View patient requests</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-primary w-full">
                            View Inquiries
                        </button>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">My Practice</h3>
                            <p class="text-sm text-gray-500">Manage practice information</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-secondary w-full">
                            Update Practice
                        </button>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Analytics</h3>
                            <p class="text-sm text-gray-500">View practice statistics</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-secondary w-full">
                            View Analytics
                        </button>
                    </div>
                </div>

            @else
                <!-- Admin Dashboard Cards -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Pending Approvals</h3>
                            <p class="text-sm text-gray-500">Review doctor applications</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-primary w-full">
                            Review Applications
                        </button>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Platform Settings</h3>
                            <p class="text-sm text-gray-500">Manage admin options</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-secondary w-full">
                            Manage Settings
                        </button>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">System Reports</h3>
                            <p class="text-sm text-gray-500">View platform analytics</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-secondary w-full">
                            View Reports
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Quick Stats -->
        <div class="mt-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Account Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-sky-600">{{ $user->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">Member Since</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600 capitalize">{{ $user->role }}</div>
                        <div class="text-sm text-gray-500">Account Type</div>
                    </div>
                    <div class="text-center">
                        @if($user->isDoctor())
                            <div class="text-2xl font-bold {{ $user->is_approved ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $user->is_approved ? 'Approved' : 'Pending' }}
                            </div>
                            <div class="text-sm text-gray-500">Approval Status</div>
                        @else
                            <div class="text-2xl font-bold text-green-600">Active</div>
                            <div class="text-sm text-gray-500">Account Status</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 