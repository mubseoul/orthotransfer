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

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-bold text-slate-900">1,247</div>
                    <div class="text-sm text-slate-500">Total Users</div>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 font-medium">+12%</span>
                <span class="text-slate-500 ml-1">from last month</span>
            </div>
        </div>

        <!-- Active Doctors -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-bold text-slate-900">284</div>
                    <div class="text-sm text-slate-500">Active Doctors</div>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 font-medium">+8%</span>
                <span class="text-slate-500 ml-1">from last month</span>
            </div>
        </div>

        <!-- Patient Transfers -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-bold text-slate-900">156</div>
                    <div class="text-sm text-slate-500">This Month</div>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 font-medium">+24%</span>
                <span class="text-slate-500 ml-1">from last month</span>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-bold text-slate-900">23</div>
                    <div class="text-sm text-slate-500">Pending Approvals</div>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-amber-600 font-medium text-sm">Requires attention</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Doctor Approvals -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="h-12 w-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-slate-900">Doctor Approvals</h3>
                    <p class="text-sm text-slate-600">Review pending applications</p>
                </div>
            </div>
            <button class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-xl transition-colors duration-200 shadow-sm">
                Review Applications (23)
            </button>
        </div>

        <!-- User Management -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-slate-900">User Management</h3>
                    <p class="text-sm text-slate-600">Manage platform users</p>
                </div>
            </div>
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl transition-colors duration-200 shadow-sm">
                Manage Users
            </button>
        </div>

        <!-- System Reports -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-slate-900">Analytics</h3>
                    <p class="text-sm text-slate-600">Platform insights & reports</p>
                </div>
            </div>
            <button class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-xl transition-colors duration-200 shadow-sm">
                View Reports
            </button>
        </div>

        <!-- System Settings -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="h-12 w-12 bg-slate-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-slate-900">Settings</h3>
                    <p class="text-sm text-slate-600">Platform configuration</p>
                </div>
            </div>
            <button class="w-full bg-slate-600 hover:bg-slate-700 text-white font-medium py-3 px-4 rounded-xl transition-colors duration-200 shadow-sm">
                Manage Settings
            </button>
        </div>

        <!-- Content Management -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-slate-900">Content</h3>
                    <p class="text-sm text-slate-600">Manage site content</p>
                </div>
            </div>
            <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl transition-colors duration-200 shadow-sm">
                Manage Content
            </button>
        </div>

        <!-- System Monitoring -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="h-12 w-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-slate-900">Monitoring</h3>
                    <p class="text-sm text-slate-600">System health & status</p>
                </div>
            </div>
            <button class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-3 px-4 rounded-xl transition-colors duration-200 shadow-sm">
                View System Status
            </button>
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