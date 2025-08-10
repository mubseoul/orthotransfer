<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'OrthoTransfer') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    @stack('styles')
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-slate-50">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-xl transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 border-r border-slate-200"
             :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-center h-20 px-6 bg-white border-b border-slate-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-slate-900 text-xl font-bold">OrthoTransfer</div>
                        <div class="text-blue-600 text-sm font-medium">Admin Console</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="mt-8 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="mr-3 h-5 w-5 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                    </div>
                    Dashboard
                </a>

                <a href="{{ route('admin.doctors.index') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.doctors.*') ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="mr-3 h-5 w-5 transition-colors duration-200 {{ request()->routeIs('admin.doctors.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    Doctors
                </a>

                <a href="{{ route('admin.patients.index') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.patients.*') ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="mr-3 h-5 w-5 transition-colors duration-200 {{ request()->routeIs('admin.patients.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Patients
                </a>

                <a href="#" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200">
                    <div class="mr-3 h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors duration-200">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    Transfers
                </a>

                <a href="#" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200">
                    <div class="mr-3 h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors duration-200">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    Reports
                </a>

                <!-- Divider -->
                <div class="border-t border-slate-200 my-4"></div>

                <!-- Options Management with Dropdown -->
                <div x-data="{ optionsOpen: false }" class="relative">
                    <button @click="optionsOpen = !optionsOpen" 
                            class="group flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200 {{ request()->routeIs('admin.options.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <div class="flex items-center">
                            <div class="mr-3 h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors duration-200 {{ request()->routeIs('admin.options.*') ? 'text-blue-600' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            Options
                        </div>
                        <svg class="h-4 w-4 text-slate-400 transition-transform duration-200" 
                             :class="{ 'rotate-180': optionsOpen }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="optionsOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-y-90"
                         x-transition:enter-end="opacity-100 scale-y-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-y-100"
                         x-transition:leave-end="opacity-0 scale-y-90"
                         class="mt-2 pl-8 space-y-1 origin-top">
                        <a href="{{ route('admin.options.index', 'treatments') }}" 
                           class="block px-4 py-2 text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.options.*') && request()->route('type') == 'treatments' ? 'bg-blue-50 text-blue-700' : '' }}">
                            Treatments
                        </a>
                        <a href="{{ route('admin.options.index', 'functional-appliances') }}" 
                           class="block px-4 py-2 text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.options.*') && request()->route('type') == 'functional-appliances' ? 'bg-blue-50 text-blue-700' : '' }}">
                            Functional Appliances
                        </a>
                        <a href="{{ route('admin.options.index', 'tads') }}" 
                           class="block px-4 py-2 text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.options.*') && request()->route('type') == 'tads' ? 'bg-blue-50 text-blue-700' : '' }}">
                            TADs
                        </a>
                        <a href="{{ route('admin.options.index', 'doctor-types') }}" 
                           class="block px-4 py-2 text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.options.*') && request()->route('type') == 'doctor-types' ? 'bg-blue-50 text-blue-700' : '' }}">
                            Doctor Types
                        </a>
                        <a href="{{ route('admin.options.index', 'transfer-types') }}" 
                           class="block px-4 py-2 text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.options.*') && request()->route('type') == 'transfer-types' ? 'bg-blue-50 text-blue-700' : '' }}">
                            Transfer Types
                        </a>
                        <a href="{{ route('admin.options.index', 'insurance-providers') }}" 
                           class="block px-4 py-2 text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.options.*') && request()->route('type') == 'insurance-providers' ? 'bg-blue-50 text-blue-700' : '' }}">
                            Insurance Providers
                        </a>
                    </div>
                </div>

                <a href="#" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200">
                    <div class="mr-3 h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors duration-200">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    Settings
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="absolute bottom-0 w-full p-4 border-t border-slate-200 bg-white">
                <a href="{{ route('home') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200 group">
                    <div class="mr-3 h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors duration-200">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    Back to Site
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-slate-200">
                <div class="flex justify-between items-center px-8 py-6">
                    <!-- Mobile menu button and Page Title -->
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <!-- Page Title -->
                        <h1 class="ml-2 lg:ml-0 text-2xl font-bold text-slate-900">
                            @yield('page-title', 'Dashboard')
                        </h1>
                    </div>

                    <!-- Header Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-3 text-slate-400 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl hover:bg-slate-50 transition-all duration-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-3.5-3.5a4.5 4.5 0 00-1.5-6.5V6a1 1 0 00-1-1H8a1 1 0 00-1 1v1a4.5 4.5 0 00-1.5 6.5L2 17h5m8 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-2 right-2 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                        </button>

                        <!-- Admin User Menu -->
                        <div class="relative" x-data="{ dropdownOpen: false }">
                            <button @click="dropdownOpen = !dropdownOpen" 
                                    @click.away="dropdownOpen = false"
                                    class="flex items-center space-x-3 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 px-4 py-3 hover:bg-slate-50 transition-all duration-200 shadow-sm">
                                <div class="h-8 w-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <div class="text-sm font-semibold text-slate-900">
                                        {{ auth('admin')->user()->full_name ?? 'Admin User' }}
                                    </div>
                                    <div class="text-xs text-slate-500">Administrator</div>
                                </div>
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="dropdownOpen" 
                                 x-transition:enter="transition ease-out duration-200" 
                                 x-transition:enter-start="transform opacity-0 scale-95" 
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100" 
                                 x-transition:leave-start="transform opacity-100 scale-100" 
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg ring-1 ring-slate-900/5 z-50 border border-slate-200">
                                <div class="py-2">
                                    <div class="px-4 py-3 text-xs text-slate-500 border-b border-slate-100 bg-slate-50 rounded-t-xl">
                                        Signed in as <span class="font-medium text-slate-900">{{ auth('admin')->user()->email ?? 'admin@example.com' }}</span>
                                    </div>
                                    <a href="{{ route('admin.profile') }}" 
                                       class="flex items-center px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-all duration-150">
                                        <div class="mr-3 h-4 w-4 text-slate-400">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        Your Profile
                                    </a>
                                    <a href="#" 
                                       class="flex items-center px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-all duration-150">
                                        <div class="mr-3 h-4 w-4 text-slate-400">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        Settings
                                    </a>
                                    <div class="border-t border-slate-100 my-1"></div>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center w-full text-left px-4 py-3 text-sm text-slate-700 hover:bg-red-50 hover:text-red-700 transition-all duration-150 rounded-b-xl">
                                            <div class="mr-3 h-4 w-4 text-slate-400">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </div>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Breadcrumbs (Optional) -->
                @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                <div class="border-t border-slate-200 px-8 py-3 bg-slate-50">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            @foreach($breadcrumbs as $breadcrumb)
                                <li class="flex items-center">
                                    @if(!$loop->first)
                                        <svg class="flex-shrink-0 h-4 w-4 text-slate-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    @if($breadcrumb['url'])
                                        <a href="{{ $breadcrumb['url'] }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors duration-150">
                                            {{ $breadcrumb['label'] }}
                                        </a>
                                    @else
                                        <span class="text-sm font-medium text-slate-900">
                                            {{ $breadcrumb['label'] }}
                                        </span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                </div>
                @endif
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-slate-50">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mx-8 mt-6">
                        <div class="rounded-xl bg-green-50 p-4 border border-green-200 shadow-sm">
                            <div class="flex">
                                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mx-8 mt-6">
                        <div class="rounded-xl bg-red-50 p-4 border border-red-200 shadow-sm">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        {{ session('error') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mx-8 mt-6">
                        <div class="rounded-xl bg-red-50 p-4 border border-red-200 shadow-sm">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        There were errors with your submission:
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <div class="px-8 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-slate-600 bg-opacity-75 lg:hidden" 
         @click="sidebarOpen = false"></div>

    @livewireScripts
    @stack('scripts')
</body>
</html> 