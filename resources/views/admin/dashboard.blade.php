@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Welcome back, {{ auth('admin')->user()->full_name ?? 'Administrator' }}!</h2>
                <p class="text-slate-600 mt-2">Here's what's happening with your platform today.</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-slate-500">{{ now()->format('l, F j, Y') }}</div>
                <div class="text-2xl font-bold text-slate-900">{{ now()->format('g:i A') }}</div>
            </div>
        </div>
    </div>


    <!-- Recent Activity -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-8 py-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-slate-900">Recent Activity</h2>
                <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
            </div>
        </div>
        <div class="p-8">
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="h-10 w-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900">New doctor approved</p>
                        <p class="text-sm text-slate-600 mt-1">Dr. Sarah Johnson from Smile Orthodontics was approved and added to the platform</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-slate-500">2 hours ago</span>
                            <span class="mx-2 text-slate-300">•</span>
                            <span class="text-xs text-green-600 font-medium">Approved</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="h-10 w-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900">New patient registration</p>
                        <p class="text-sm text-slate-600 mt-1">John Doe registered as a new patient seeking orthodontic care</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-slate-500">4 hours ago</span>
                            <span class="mx-2 text-slate-300">•</span>
                            <span class="text-xs text-blue-600 font-medium">Registration</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="h-10 w-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900">System alert</p>
                        <p class="text-sm text-slate-600 mt-1">High server load detected on web server 2 - monitoring closely</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-slate-500">6 hours ago</span>
                            <span class="mx-2 text-slate-300">•</span>
                            <span class="text-xs text-amber-600 font-medium">Alert</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="h-10 w-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900">Transfer completed</p>
                        <p class="text-sm text-slate-600 mt-1">Patient transfer from Dr. Miller to Dr. Anderson completed successfully</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-slate-500">8 hours ago</span>
                            <span class="mx-2 text-slate-300">•</span>
                            <span class="text-xs text-purple-600 font-medium">Transfer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 