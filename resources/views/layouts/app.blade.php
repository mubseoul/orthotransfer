<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OrthoTransfer') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left side: Logo and Navigation -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') ?? '/' }}" class="flex items-center">
                            <div class="h-8 w-8 bg-sky-500 rounded-lg flex items-center justify-center">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="ml-2 text-xl font-semibold text-gray-900">OrthoTransfer</span>
                        </a>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="hidden md:flex space-x-8">
                        <a href="{{ route('home') ?? '/' }}" class="text-gray-700 hover:text-sky-600 px-3 py-2 text-sm font-medium transition-colors">
                            Home
                        </a>
                        <a href="" class="text-gray-700 hover:text-sky-600 px-3 py-2 text-sm font-medium transition-colors">
                            Find Doctors
                        </a>
                        <a href="" class="text-gray-700 hover:text-sky-600 px-3 py-2 text-sm font-medium transition-colors">
                            How It Works
                        </a>
                        <a href="" class="text-gray-700 hover:text-sky-600 px-3 py-2 text-sm font-medium transition-colors">
                            About
                        </a>
                        @auth
                            @if(auth()->user()->isDoctor())
                                <a href="" class="text-gray-700 hover:text-sky-600 px-3 py-2 text-sm font-medium transition-colors">
                                    My Practice
                                </a>
                            @endif
                        @endauth
                    </nav>
                </div>

                <!-- Right side: User Authentication -->
                <div class="flex items-center space-x-4">
                    @guest
                        <!-- Guest User Actions -->
                        <a href="" class="text-gray-700 hover:text-sky-600 px-3 py-2 text-sm font-medium transition-colors">
                            Sign In
                        </a>
                        <a href="" class="btn-primary">
                            Get Started
                        </a>
                    @else
                        <!-- Authenticated User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" 
                                    class="flex items-center space-x-2 text-gray-700 hover:text-sky-600 px-3 py-2 text-sm font-medium transition-colors">
                                <div class="h-8 w-8 bg-sky-500 rounded-full flex items-center justify-center">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span>{{ auth()->user()->first_name }}</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-100" 
                                 x-transition:enter-start="transform opacity-0 scale-95" 
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75" 
                                 x-transition:leave-start="transform opacity-100 scale-100" 
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <a href="" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Dashboard
                                    </a>
                                    <a href="" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Profile Settings
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="" 
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Admin Panel
                                        </a>
                                    @endif
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="">
                                        @csrf
                                        <button type="submit" 
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest

                    <!-- Mobile menu button -->
                    <button class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-sky-500"
                            x-data @click="$dispatch('toggle-mobile-menu')">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div class="md:hidden" x-data="{ mobileOpen: false }" @toggle-mobile-menu.window="mobileOpen = !mobileOpen">
                <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-100" 
                     x-transition:enter-start="transform opacity-0 scale-95" 
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75" 
                     x-transition:leave-start="transform opacity-100 scale-100" 
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="border-t border-gray-200 pb-3 pt-4">
                    <div class="space-y-1">
                        <a href="{{ route('home') ?? '/' }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-sky-600 hover:bg-gray-50">
                            Home
                        </a>
                        <a href="" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-sky-600 hover:bg-gray-50">
                            Find Doctors
                        </a>
                        <a href="" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-sky-600 hover:bg-gray-50">
                            How It Works
                        </a>
                        <a href="" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-sky-600 hover:bg-gray-50">
                            About
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <div class="h-8 w-8 bg-sky-500 rounded-lg flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-xl font-semibold">OrthoTransfer</span>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        Connecting patients with qualified orthodontists for seamless treatment transfers. 
                        Find the right doctor to continue your orthodontic journey.
                    </p>
                    
                    <!-- Social Media Icons -->
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.004 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.596-3.205-1.538H3.786v.616c0 .641.52 1.161 1.161 1.161h12.106c.641 0 1.161-.52 1.161-1.161v-.616h-1.458c-.757.942-1.908 1.538-3.205 1.538H8.449z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">How It Works</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Find Doctors</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                        <li><
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm">
                    © {{ date('Y') }} OrthoTransfer. All rights reserved.
                </div>
                <div class="mt-4 md:mt-0 flex space-x-6 text-sm text-gray-400">
                    <a href="" class="hover:text-white transition-colors">Privacy</a>
                    <a href="" class="hover:text-white transition-colors">Terms</a>
                    <a href="" class="hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html> 