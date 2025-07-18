<!-- Welcome Section -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ $user->first_name }}!</h1>
            <p class="text-gray-600 mt-2">
                @if($user->isPatient())
                    Patient Dashboard - Find and connect with orthodontists
                @elseif($user->isDoctor())
                    Doctor Dashboard - Manage your practice and patient connections
                @else
                    Dashboard - Manage your OrthoTransfer profile
                @endif
            </p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</div>
            <div class="text-2xl font-bold text-gray-900">{{ now()->format('g:i A') }}</div>
        </div>
    </div>
</div> 