@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar -->
        <x-dashboard-sidebar />

        <!-- Main Content -->
        <div class="flex-1">
            <div class="space-y-8">
                <!-- Header Section -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Profile</h1>
                        <p class="text-gray-600 mt-1">Manage your personal information and preferences</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                        </div>

                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- First Name -->
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           id="first_name" 
                                           name="first_name" 
                                           value="{{ old('first_name', $user->first_name) }}"
                                           class="form-input @error('first_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                           required>
                                    @error('first_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           id="last_name" 
                                           name="last_name" 
                                           value="{{ old('last_name', $user->last_name) }}"
                                           class="form-input @error('last_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                           required>
                                    @error('last_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="form-input @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       required>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Profile Picture Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Profile Picture</h3>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center space-x-6">
                                <!-- Current Profile Picture -->
                                <div class="flex-shrink-0">
                                    <img class="h-24 w-24 rounded-full object-cover border-4 border-gray-200" 
                                         src="{{ $user->profile_picture_url }}" 
                                         alt="Profile picture"
                                         id="profile-preview">
                                </div>

                                <!-- Upload Section -->
                                <div class="flex-1">
                                    <div class="form-group">
                                        <label for="profile_picture" class="form-label">Upload New Picture</label>
                                        <input type="file" 
                                               id="profile_picture" 
                                               name="profile_picture" 
                                               accept="image/*"
                                               class="form-input @error('profile_picture') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               onchange="previewImage(this)">
                                        <p class="mt-2 text-sm text-gray-500">
                                            JPG, PNG, or GIF. Max size 2MB.
                                        </p>
                                        @error('profile_picture')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($user->isPatient())
                        <!-- Patient Profile Information -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Patient Information</h3>
                            </div>

                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Age -->
                                    <div class="form-group">
                                        <label for="age" class="form-label">Age <span class="text-red-500">*</span></label>
                                        <input type="number" 
                                               id="age" 
                                               name="age" 
                                               min="1" 
                                               max="120"
                                               value="{{ old('age', $profile->age ?? '') }}"
                                               class="form-input @error('age') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               required>
                                        @error('age')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Radius Willing to Drive -->
                                    <div class="form-group">
                                        <label for="radius_willing_to_drive" class="form-label">Willing to Drive (miles) <span class="text-red-500">*</span></label>
                                        <input type="number" 
                                               id="radius_willing_to_drive" 
                                               name="radius_willing_to_drive" 
                                               min="1" 
                                               max="500"
                                               value="{{ old('radius_willing_to_drive', $profile->radius_willing_to_drive ?? '') }}"
                                               class="form-input @error('radius_willing_to_drive') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               required>
                                        @error('radius_willing_to_drive')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Moving Temporarily -->
                                <div class="form-group">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="moving_temporarily" 
                                               name="moving_temporarily" 
                                               value="1"
                                               {{ old('moving_temporarily', $profile->moving_temporarily ?? false) ? 'checked' : '' }}
                                               class="form-checkbox">
                                        <label for="moving_temporarily" class="ml-3 text-sm font-medium text-gray-700">
                                            I am moving temporarily
                                        </label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Current Orthodontist Name -->
                                    <div class="form-group">
                                        <label for="current_orthodontist_name" class="form-label">Current Orthodontist Name <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                               id="current_orthodontist_name" 
                                               name="current_orthodontist_name" 
                                               value="{{ old('current_orthodontist_name', $profile->current_orthodontist_name ?? '') }}"
                                               class="form-input @error('current_orthodontist_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               required>
                                        @error('current_orthodontist_name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Treatment Length -->
                                    <div class="form-group">
                                        <label for="original_treatment_length_months" class="form-label">Original Treatment Length (months) <span class="text-red-500">*</span></label>
                                        <input type="number" 
                                               id="original_treatment_length_months" 
                                               name="original_treatment_length_months" 
                                               min="1" 
                                               max="120"
                                               value="{{ old('original_treatment_length_months', $profile->original_treatment_length_months ?? '') }}"
                                               class="form-input @error('original_treatment_length_months') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               required>
                                        @error('original_treatment_length_months')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Orthodontist Address -->
                                <div class="form-group">
                                    <label for="orthodontist_address" class="form-label">Current Orthodontist Address <span class="text-red-500">*</span></label>
                                    <textarea id="orthodontist_address" 
                                              name="orthodontist_address" 
                                              rows="3"
                                              class="form-textarea @error('orthodontist_address') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                              required>{{ old('orthodontist_address', $profile->orthodontist_address ?? '') }}</textarea>
                                    @error('orthodontist_address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Remaining Financial Amount -->
                                <div class="form-group">
                                    <label for="remaining_financial_amount" class="form-label">Remaining Financial Amount (USD) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" 
                                               id="remaining_financial_amount" 
                                               name="remaining_financial_amount" 
                                               min="0" 
                                               max="999999.99"
                                               step="0.01"
                                               value="{{ old('remaining_financial_amount', $profile->remaining_financial_amount ?? '') }}"
                                               class="form-input pl-8 @error('remaining_financial_amount') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               required>
                                    </div>
                                    @error('remaining_financial_amount')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Doctor Type Preference -->
                                @if(isset($doctorTypes) && $doctorTypes->count() > 0)
                                <div class="form-group">
                                    <label for="doctor_type_id" class="form-label">Preferred Doctor Type</label>
                                    <select id="doctor_type_id" 
                                            name="doctor_type_id" 
                                            class="form-select @error('doctor_type_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                        <option value="">Select a doctor type</option>
                                        @foreach($doctorTypes as $doctorType)
                                            <option value="{{ $doctorType->id }}" 
                                                    {{ old('doctor_type_id', $profile->doctor_type_id ?? '') == $doctorType->id ? 'selected' : '' }}>
                                                {{ $doctorType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('doctor_type_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                @endif

                                <!-- Treatment Options -->
                                @if(isset($treatments) && $treatments->count() > 0)
                                <div class="form-group">
                                    <label class="form-label">Current Treatments</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($treatments as $treatment)
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       id="treatment_{{ $treatment->id }}" 
                                                       name="treatments[]" 
                                                       value="{{ $treatment->id }}"
                                                       {{ in_array($treatment->id, old('treatments', $profile->treatments->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                                       class="form-checkbox">
                                                <label for="treatment_{{ $treatment->id }}" class="ml-3 text-sm text-gray-700">
                                                    {{ $treatment->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Functional Appliances -->
                                @if(isset($functionalAppliances) && $functionalAppliances->count() > 0)
                                <div class="form-group">
                                    <label class="form-label">Functional Appliances</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($functionalAppliances as $appliance)
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       id="appliance_{{ $appliance->id }}" 
                                                       name="functional_appliances[]" 
                                                       value="{{ $appliance->id }}"
                                                       {{ in_array($appliance->id, old('functional_appliances', $profile->functionalAppliances->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                                       class="form-checkbox">
                                                <label for="appliance_{{ $appliance->id }}" class="ml-3 text-sm text-gray-700">
                                                    {{ $appliance->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- TADs -->
                                @if(isset($tads) && $tads->count() > 0)
                                <div class="form-group">
                                    <label class="form-label">TADs (Temporary Anchorage Devices)</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($tads as $tad)
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       id="tad_{{ $tad->id }}" 
                                                       name="tads[]" 
                                                       value="{{ $tad->id }}"
                                                       {{ in_array($tad->id, old('tads', $profile->tads->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                                       class="form-checkbox">
                                                <label for="tad_{{ $tad->id }}" class="ml-3 text-sm text-gray-700">
                                                    {{ $tad->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                    @elseif($user->isDoctor())
                        <!-- Doctor Profile Information -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Professional Information</h3>
                            </div>

                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Title -->
                                    <div class="form-group">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" 
                                               id="title" 
                                               name="title" 
                                               value="{{ old('title', $profile->title ?? '') }}"
                                               placeholder="Dr., DDS, DMD, etc."
                                               class="form-input @error('title') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                        @error('title')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="form-group">
                                        <label for="phone_number" class="form-label">Phone Number <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                               id="phone_number" 
                                               name="phone_number" 
                                               value="{{ old('phone_number', $profile->phone_number ?? '') }}"
                                               class="form-input @error('phone_number') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               required>
                                        @error('phone_number')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Website -->
                                <div class="form-group">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" 
                                           id="website" 
                                           name="website" 
                                           value="{{ old('website', $profile->website ?? '') }}"
                                           placeholder="https://example.com"
                                           class="form-input @error('website') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                    @error('website')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Bio -->
                                <div class="form-group">
                                    <label for="bio" class="form-label">Professional Bio</label>
                                    <textarea id="bio" 
                                              name="bio" 
                                              rows="4"
                                              maxlength="1000"
                                              placeholder="Tell patients about your experience and specialties..."
                                              class="form-textarea @error('bio') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                    @error('bio')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Minimum Monthly Payment -->
                                <div class="form-group">
                                    <label for="minimum_monthly_payment" class="form-label">Minimum Monthly Payment (USD) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" 
                                               id="minimum_monthly_payment" 
                                               name="minimum_monthly_payment" 
                                               min="0" 
                                               max="999999.99"
                                               step="0.01"
                                               value="{{ old('minimum_monthly_payment', $profile->minimum_monthly_payment ?? '') }}"
                                               class="form-input pl-8 @error('minimum_monthly_payment') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               required>
                                    </div>
                                    @error('minimum_monthly_payment')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Transfer Types -->
                                @if(isset($transferTypes) && $transferTypes->count() > 0)
                                <div class="form-group">
                                    <label class="form-label">Transfer Types Offered</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($transferTypes as $transferType)
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       id="transfer_type_{{ $transferType->id }}" 
                                                       name="transfer_types[]" 
                                                       value="{{ $transferType->id }}"
                                                       {{ in_array($transferType->id, old('transfer_types', $profile->transferTypes->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                                       class="form-checkbox">
                                                <label for="transfer_type_{{ $transferType->id }}" class="ml-3 text-sm text-gray-700">
                                                    {{ $transferType->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Insurance Providers -->
                                @if(isset($insuranceProviders) && $insuranceProviders->count() > 0)
                                <div class="form-group">
                                    <label class="form-label">Insurance Providers Accepted</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($insuranceProviders as $provider)
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       id="insurance_{{ $provider->id }}" 
                                                       name="insurance_providers[]" 
                                                       value="{{ $provider->id }}"
                                                       {{ in_array($provider->id, old('insurance_providers', $profile->insuranceProviders->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                                       class="form-checkbox">
                                                <label for="insurance_{{ $provider->id }}" class="ml-3 text-sm text-gray-700">
                                                    {{ $provider->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <a href="{{ route('dashboard') }}" 
                           class="px-6 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-xl transition-colors duration-200 border border-gray-300">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-sm">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('profile-preview');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection 