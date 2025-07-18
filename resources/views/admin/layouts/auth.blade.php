<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Login') - {{ config('app.name', 'OrthoTransfer') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @stack('styles')
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 font-sans antialiased">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-slate-100/5 bg-[size:32px_32px] [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.5))]"></div>
        
        <!-- Header with Logo -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md relative">
            <div class="flex justify-center">
                <div class="flex items-center">
                    <div class="h-14 w-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-2xl">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-white text-2xl font-bold">OrthoTransfer</div>
                        <div class="text-blue-300 text-sm font-medium">Admin Console</div>
                    </div>
                </div>
            </div>
            
            <h2 class="mt-8 text-center text-3xl font-bold text-white">
                @yield('heading', 'Welcome Back')
            </h2>
            
            <p class="mt-3 text-center text-sm text-slate-300">
                @yield('subheading', 'Sign in to access the admin console')
            </p>
        </div>

        <!-- Main Content -->
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md relative">
            <div class="bg-white/95 backdrop-blur-xl py-10 px-6 shadow-2xl sm:rounded-2xl sm:px-12 border border-white/20">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6">
                        <div class="rounded-xl bg-green-50 p-4 border border-green-200">
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
                    <div class="mb-6">
                        <div class="rounded-xl bg-red-50 p-4 border border-red-200">
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
                    <div class="mb-6">
                        <div class="rounded-xl bg-red-50 p-4 border border-red-200">
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

                @yield('content')
            </div>

            <!-- Back to Main Site -->
            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" 
                   class="text-blue-300 hover:text-blue-200 text-sm font-medium transition-colors duration-200 flex items-center justify-center group">
                    <svg class="mr-2 h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Main Site
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center relative">
            <p class="text-xs text-slate-400">
                © {{ date('Y') }} OrthoTransfer. Admin Console.
            </p>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html> 