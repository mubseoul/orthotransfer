@extends('admin.layouts.app')

@section('page-title', 'Your Profile')

@section('content')
<div class="max-w-4xl space-y-8">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">Account Overview</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div>
                <div class="text-slate-500">Admin ID</div>
                <div class="text-slate-900 font-medium">{{ $admin->id }}</div>
            </div>
            <div>
                <div class="text-slate-500">Email Verified</div>
                <div class="flex items-center space-x-3">
                    @if($admin->email_verified_at)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Verified</span>
                        <form method="POST" action="{{ route('admin.profile.unverify-email') }}">
                            @csrf
                            @method('PUT')
                            <button class="text-xs text-slate-600 hover:text-slate-800">Mark as unverified</button>
                        </form>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Not verified</span>
                        <form method="POST" action="{{ route('admin.profile.verify-email') }}">
                            @csrf
                            @method('PUT')
                            <button class="text-xs text-slate-600 hover:text-slate-800">Mark as verified</button>
                        </form>
                    @endif
                </div>
            </div>
            <div>
                <div class="text-slate-500">Created</div>
                <div class="text-slate-900 font-medium">{{ $admin->created_at->format('M d, Y h:i A') }}</div>
            </div>
            <div>
                <div class="text-slate-500">Last Updated</div>
                <div class="text-slate-900 font-medium">{{ $admin->updated_at->format('M d, Y h:i A') }}</div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">Profile Information</h2>
        </div>

        <form method="POST" action="{{ route('admin.profile.update') }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $admin->first_name) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $admin->last_name) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">New Password</label>
                    <input type="password" name="password" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Leave blank to keep current">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

