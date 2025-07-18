@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar -->
        <div class="lg:w-72 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Sidebar Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-sky-50">
                    <h2 class="text-lg font-semibold text-gray-900">Dashboard</h2>
                    <p class="text-sm text-gray-600">{{ auth()->user()->full_name }}</p>
                </div>

                <!-- Navigation -->
                <nav class="p-4 space-y-2">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('dashboard.profile') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard.profile') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard.profile') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>

                    <a href="{{ route('dashboard.addresses') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard.addresses*') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard.addresses*') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Addresses
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="space-y-8">
                <!-- Header Section -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Address</h1>
                        <p class="text-gray-600 mt-1">Update your address information</p>
                    </div>
                    <a href="{{ route('dashboard.addresses') }}" 
                       class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-xl transition-colors duration-200 border border-gray-300">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Addresses
                    </a>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Address Information</h3>
                    </div>

                    <form method="POST" action="{{ route('dashboard.addresses.update', $address) }}" class="p-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Address Label and Type -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Address Label -->
                            <div class="form-group">
                                <label for="label" class="form-label">Address Label <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="label" 
                                       name="label" 
                                       value="{{ old('label', $address->label) }}"
                                       placeholder="e.g., Home, Work, School"
                                       class="form-input @error('label') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       required>
                                @error('label')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address Type -->
                            <div class="form-group">
                                <label for="address_type" class="form-label">Address Type <span class="text-red-500">*</span></label>
                                <select id="address_type" 
                                        name="address_type" 
                                        class="form-select @error('address_type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <option value="">Select address type</option>
                                    <option value="current" {{ old('address_type', $address->is_current ? 'current' : 'other') === 'current' ? 'selected' : '' }}>Current Address</option>
                                    <option value="previous" {{ old('address_type', $address->is_current ? 'current' : 'other') === 'previous' ? 'selected' : '' }}>Previous Address</option>
                                    <option value="other" {{ old('address_type', $address->is_current ? 'current' : 'other') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Only one address can be marked as current at a time.</p>
                                @error('address_type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address Lines -->
                        <div class="form-group">
                            <label for="address_line_1" class="form-label">Address Line 1 <span class="text-red-500">*</span></label>
                            <input type="text" 
                                   id="address_line_1" 
                                   name="address_line_1" 
                                   value="{{ old('address_line_1', $address->address_line_1) }}"
                                   placeholder="Street number and name"
                                   class="form-input @error('address_line_1') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   required>
                            @error('address_line_1')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address_line_2" class="form-label">Address Line 2</label>
                            <input type="text" 
                                   id="address_line_2" 
                                   name="address_line_2" 
                                   value="{{ old('address_line_2', $address->address_line_2) }}"
                                   placeholder="Apartment, suite, unit, building, floor, etc."
                                   class="form-input @error('address_line_2') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            @error('address_line_2')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City, State, Postal Code -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- City -->
                            <div class="form-group">
                                <label for="city" class="form-label">City <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="city" 
                                       name="city" 
                                       value="{{ old('city', $address->city) }}"
                                       class="form-input @error('city') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       required>
                                @error('city')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- State -->
                            <div class="form-group">
                                <label for="state" class="form-label">State/Province <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="state" 
                                       name="state" 
                                       value="{{ old('state', $address->state) }}"
                                       class="form-input @error('state') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       required>
                                @error('state')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="form-group">
                                <label for="postal_code" class="form-label">Postal Code <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="postal_code" 
                                       name="postal_code" 
                                       value="{{ old('postal_code', $address->postal_code) }}"
                                       class="form-input @error('postal_code') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       required>
                                @error('postal_code')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="form-group">
                            <label for="country" class="form-label">Country <span class="text-red-500">*</span></label>
                            <input type="text" 
                                   id="country" 
                                   name="country" 
                                   value="{{ old('country', $address->country) }}"
                                   class="form-input @error('country') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   required>
                            @error('country')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('dashboard.addresses') }}" 
                               class="px-6 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-xl transition-colors duration-200 border border-gray-300">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-sm">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Address
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 