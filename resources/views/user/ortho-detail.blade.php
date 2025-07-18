@extends('layouts.user')

@section('main-content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Ortho Detail Management</h1>
            <p class="text-gray-600 mt-2">Manage your orthodontic treatment information to help doctors understand your needs</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('dashboard.ortho-detail.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Personal Information Section -->
        <div class="bg-gray-50 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="mr-2 h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Personal Information
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Age -->
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Age *</label>
                    <input type="number" 
                           id="age" 
                           name="age" 
                           value="{{ old('age', $profile?->age ?? '') }}"
                           min="1" 
                           max="120"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors"
                           required>
                </div>

                <!-- Radius Willing to Drive -->
                <div>
                    <label for="radius_willing_to_drive" class="block text-sm font-medium text-gray-700 mb-2">Radius Willing to Drive (miles) *</label>
                    <input type="number" 
                           id="radius_willing_to_drive" 
                           name="radius_willing_to_drive" 
                           value="{{ old('radius_willing_to_drive', $profile?->radius_willing_to_drive ?? '') }}"
                           min="1" 
                           max="500"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors"
                           required>
                </div>

                <!-- Moving Temporarily -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="moving_temporarily" 
                               value="1"
                               {{ old('moving_temporarily', $profile?->moving_temporarily ?? false) ? 'checked' : '' }}
                               class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">I am moving temporarily</span>
                    </label>
                </div>

                <!-- Doctor Type Preference -->
                <div class="md:col-span-2">
                    <label for="doctor_type_id" class="block text-sm font-medium text-gray-700 mb-2">Preferred Doctor Type *</label>
                    <select id="doctor_type_id" 
                            name="doctor_type_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors"
                            required>
                        <option value="">Select a doctor type...</option>
                        @foreach($doctorTypes as $doctorType)
                            <option value="{{ $doctorType->id }}" 
                                    {{ old('doctor_type_id', $profile?->doctor_type_id ?? '') == $doctorType->id ? 'selected' : '' }}>
                                {{ $doctorType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Current Treatment Information Section -->
        <div class="bg-gray-50 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="mr-2 h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Current Treatment Information
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Current Orthodontist -->
                <div>
                    <label for="current_orthodontist_name" class="block text-sm font-medium text-gray-700 mb-2">Current Orthodontist Name</label>
                    <input type="text" 
                           id="current_orthodontist_name" 
                           name="current_orthodontist_name" 
                           value="{{ old('current_orthodontist_name', $profile?->current_orthodontist_name ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors">
                </div>

                <!-- Orthodontist Address -->
                <div>
                    <label for="orthodontist_address" class="block text-sm font-medium text-gray-700 mb-2">Orthodontist Address</label>
                    <input type="text" 
                           id="orthodontist_address" 
                           name="orthodontist_address" 
                           value="{{ old('orthodontist_address', $profile?->orthodontist_address ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors">
                </div>

                <!-- Original Treatment Length -->
                <div>
                    <label for="original_treatment_length_months" class="block text-sm font-medium text-gray-700 mb-2">Original Treatment Length (months) *</label>
                    <input type="number" 
                           id="original_treatment_length_months" 
                           name="original_treatment_length_months" 
                           value="{{ old('original_treatment_length_months', $profile?->original_treatment_length_months ?? '') }}"
                           min="1" 
                           max="120"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors"
                           required>
                </div>

                <!-- Remaining Financial Amount -->
                <div>
                    <label for="remaining_financial_amount" class="block text-sm font-medium text-gray-700 mb-2">Remaining Financial Amount (USD) *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input type="number" 
                               id="remaining_financial_amount" 
                               name="remaining_financial_amount" 
                               value="{{ old('remaining_financial_amount', $profile?->remaining_financial_amount ?? '') }}"
                               step="0.01"
                               min="0"
                               max="99999.99"
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors"
                               required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Treatments Section -->
        <div class="bg-gray-50 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="mr-2 h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                Current Treatments
            </h2>
            <p class="text-sm text-gray-600 mb-4">Select all treatments you currently have</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($treatments as $treatment)
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white transition-colors cursor-pointer">
                        <input type="checkbox" 
                               name="treatments[]" 
                               value="{{ $treatment->id }}"
                               {{ in_array($treatment->id, old('treatments', $profile?->treatments->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                               class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                        <span class="ml-3 text-sm text-gray-700">{{ $treatment->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Functional Appliances Section -->
        <div class="bg-gray-50 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="mr-2 h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                Functional Appliances
            </h2>
            <p class="text-sm text-gray-600 mb-4">Select all functional appliances you currently have</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($functionalAppliances as $appliance)
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white transition-colors cursor-pointer">
                        <input type="checkbox" 
                               name="functional_appliances[]" 
                               value="{{ $appliance->id }}"
                               {{ in_array($appliance->id, old('functional_appliances', $profile?->functionalAppliances->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                               class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                        <span class="ml-3 text-sm text-gray-700">{{ $appliance->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- TADs Section -->
        <div class="bg-gray-50 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="mr-2 h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                </svg>
                TADs (Temporary Anchorage Devices)
            </h2>
            <p class="text-sm text-gray-600 mb-4">Select all TADs you currently have</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($tads as $tad)
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white transition-colors cursor-pointer">
                        <input type="checkbox" 
                               name="tads[]" 
                               value="{{ $tad->id }}"
                               {{ in_array($tad->id, old('tads', $profile?->tads->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                               class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                        <span class="ml-3 text-sm text-gray-700">{{ $tad->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="px-6 py-3 bg-sky-600 text-white font-medium rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-colors">
                Update Ortho Details
            </button>
        </div>
    </form>
</div>
@endsection 