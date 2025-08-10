@extends('layouts.user')

@section('main-content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Practice Settings</h1>
            <p class="text-gray-600 mt-2">Manage your practice details, treatments and insurances</p>
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

    @php
        $selectedTransferTypeIds = old('transfer_types', $profile?->transferTypes?->pluck('id')->toArray() ?? []);
        $selectedInsuranceProviderIds = old('insurance_providers', $profile?->insuranceProviders?->pluck('id')->toArray() ?? []);
    @endphp

    <form method="POST" action="{{ route('dashboard.practice.update') }}" class="space-y-10">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-1 gap-10">
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-900">Doctor / Practice Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', optional($profile)->title) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone number</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', optional($profile)->phone_number) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input type="url" name="website" value="{{ old('website', optional($profile)->website) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum monthly payment</label>
                        <input type="number" step="0.01" name="minimum_monthly_payment" value="{{ old('minimum_monthly_payment', optional($profile)->minimum_monthly_payment) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea name="bio" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">{{ old('bio', optional($profile)->bio) }}</textarea>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Treatment Types</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($transferTypes as $type)
                            <label class="inline-flex items-start gap-2 p-3 rounded-lg border border-gray-200 hover:bg-gray-50">
                                <input type="checkbox" name="transfer_types[]" value="{{ $type->id }}" 
                                    {{ in_array($type->id, (array) $selectedTransferTypeIds) ? 'checked' : '' }}
                                    class="mt-1 h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                                <span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $type->name }}</span>
                                    @if($type->description)
                                        <span class="block text-xs text-gray-500">{{ $type->description }}</span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Insurances</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($insuranceProviders as $provider)
                            <label class="inline-flex items-start gap-2 p-3 rounded-lg border border-gray-200 hover:bg-gray-50">
                                <input type="checkbox" name="insurance_providers[]" value="{{ $provider->id }}" 
                                    {{ in_array($provider->id, (array) $selectedInsuranceProviderIds) ? 'checked' : '' }}
                                    class="mt-1 h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                                <span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $provider->name }}</span>
                                    @if($provider->description)
                                        <span class="block text-xs text-gray-500">{{ $provider->description }}</span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-sky-600 text-white font-medium rounded-lg hover:bg-sky-700">Save Settings</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@endpush