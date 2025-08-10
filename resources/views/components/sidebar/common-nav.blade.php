<!-- Dashboard Link -->
<a href="{{ route('dashboard') }}" 
   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
    </svg>
    Dashboard
</a>

<!-- Profile Link -->
<a href="{{ route('dashboard.profile') }}" 
   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard.profile') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard.profile') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
    </svg>
    Profile
</a>

<!-- Practice Settings (Doctor Only) -->
@if($user && $user->isDoctor())
<a href="{{ route('dashboard.practice') }}" 
   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard.practice') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard.practice') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
    </svg>
    Practice Settings
</a>
<a href="{{ route('dashboard.practice.address') }}" 
   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard.practice.address') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard.practice.address') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z" />
    </svg>
    Practice Address
</a>
@endif 

<!-- Ortho Details Link (Patient Only) -->
@if($user && $user->isPatient())
<a href="{{ route('dashboard.ortho-detail') }}" 
   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard.ortho-detail') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard.ortho-detail') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
    </svg>
    Ortho Details
</a>
@endif 

<!-- Addresses Link (Patient Only) -->
@if($user && $user->isPatient())
<a href="{{ route('dashboard.addresses.index') }}" 
   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard.addresses.*') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard.addresses.*') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z" />
    </svg>
    Addresses
</a>
@endif