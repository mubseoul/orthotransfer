<div class="px-6 py-4 border-b border-gray-200 bg-sky-50">
    <div class="flex items-center space-x-3">
        <img class="h-10 w-10 rounded-full object-cover border-2 border-sky-200" 
             src="{{ $user->profile_picture ?? asset('images/default-avatar.png') }}" 
             alt="Profile picture">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Dashboard</h2>
            <p class="text-sm text-gray-600">{{ $user->full_name }}</p>
        </div>
    </div>
</div> 