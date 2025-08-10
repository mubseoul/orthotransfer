@extends('admin.layouts.app')

@section('page-title', 'Patient Details')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-slate-900">{{ $user->full_name }} ({{ $user->email }})</h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Edit Patient</h3>
        </div>
        <form method="POST" action="{{ route('admin.patients.update', $user) }}" class="p-6 space-y-6">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Age</label>
                    <input type="number" name="patient_profile[age]" value="{{ old('patient_profile.age', optional($user->patientProfile)->age) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Radius Willing To Drive (miles)</label>
                    <input type="number" name="patient_profile[radius_willing_to_drive]" value="{{ old('patient_profile.radius_willing_to_drive', optional($user->patientProfile)->radius_willing_to_drive) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Moving Temporarily</label>
                    <select name="patient_profile[moving_temporarily]" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                        <option value="0" {{ old('patient_profile.moving_temporarily', optional($user->patientProfile)->moving_temporarily) ? '' : 'selected' }}>No</option>
                        <option value="1" {{ old('patient_profile.moving_temporarily', optional($user->patientProfile)->moving_temporarily) ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Current Orthodontist Name</label>
                <input type="text" name="patient_profile[current_orthodontist_name]" value="{{ old('patient_profile.current_orthodontist_name', optional($user->patientProfile)->current_orthodontist_name) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Orthodontist Address</label>
                <textarea name="patient_profile[orthodontist_address]" rows="3" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">{{ old('patient_profile.orthodontist_address', optional($user->patientProfile)->orthodontist_address) }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Original Treatment Length (months)</label>
                    <input type="number" name="patient_profile[original_treatment_length_months]" value="{{ old('patient_profile.original_treatment_length_months', optional($user->patientProfile)->original_treatment_length_months) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Remaining Financial Amount ($)</label>
                    <input type="number" step="0.01" min="0" name="patient_profile[remaining_financial_amount]" value="{{ old('patient_profile.remaining_financial_amount', optional($user->patientProfile)->remaining_financial_amount) }}" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Preferred Doctor Type</label>
                <select name="patient_profile[doctor_type_id]" class="mt-1 block w-full border border-slate-200 rounded-lg px-3 py-2">
                    <option value="">None</option>
                    @foreach($doctorTypes as $type)
                        <option value="{{ $type->id }}" {{ (old('patient_profile.doctor_type_id', optional($user->patientProfile)->doctor_type_id) == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm">Save Changes</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Linked Doctors</h3>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($user->doctors as $doctor)
                        <tr>
                            <td class="px-4 py-3 text-sm text-slate-800">{{ $doctor->full_name }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $doctor->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-6 text-center text-sm text-slate-500">No linked doctors.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

