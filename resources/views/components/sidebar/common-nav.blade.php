<!-- Dashboard Link -->
<a href="{{ route('dashboard') }}" 
   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-sky-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
    </svg>
    Dashboard
</a> 