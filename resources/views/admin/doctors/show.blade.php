@extends('admin.layouts.app')

@section('page-title', 'Doctor Details')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-slate-900">{{ $user->full_name }} ({{ $user->email }})</h2>
        <div class="space-x-2">
            @if(!$user->is_approved)
                <form method="POST" action="{{ route('admin.doctors.approve', $user) }}" class="inline">
                    @csrf
                    @method('PUT')
                    <button class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-sm">Approve</button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.doctors.unapprove', $user) }}" class="inline">
                    @csrf
                    @method('PUT')
                    <button class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 text-sm">Unapprove</button>
                </form>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Edit Doctor</h3>
        </div>
        <form method="POST" action="{{ route('admin.doctors.update', $user) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Title</label>
                    <input type="text" name="doctor_profile[title]" value="{{ old('doctor_profile.title', optional($user->doctorProfile)->title) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Phone Number</label>
                    <input type="text" name="doctor_profile[phone_number]" value="{{ old('doctor_profile.phone_number', optional($user->doctorProfile)->phone_number) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Website</label>
                    <input type="url" name="doctor_profile[website]" value="{{ old('doctor_profile.website', optional($user->doctorProfile)->website) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Min Monthly Payment ($)</label>
                    <input type="number" step="0.01" min="0" name="doctor_profile[minimum_monthly_payment]" value="{{ old('doctor_profile.minimum_monthly_payment', optional($user->doctorProfile)->minimum_monthly_payment) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Bio</label>
                <textarea name="doctor_profile[bio]" rows="4" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">{{ old('doctor_profile.bio', optional($user->doctorProfile)->bio) }}</textarea>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm">Save Changes</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Linked Patients</h3>
            <form method="POST" action="{{ route('admin.doctors.patients.attach', $user) }}" class="flex items-center space-x-2">
                @csrf
                <input type="number" name="patient_user_id" placeholder="Patient User ID" class="border border-slate-200 rounded-lg px-3 py-2 text-sm" required>
                <button class="px-3 py-2 rounded-lg bg-slate-100 text-slate-800 text-sm">Link Patient</button>
            </form>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($user->patients as $patient)
                        <tr>
                            <td class="px-4 py-3 text-sm text-slate-800">{{ $patient->full_name }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $patient->email }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('admin.doctors.patients.detach', [$user, $patient]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-lg bg-red-50 text-red-700 text-sm">Unlink</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm text-slate-500">No linked patients yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

