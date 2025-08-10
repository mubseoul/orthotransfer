@extends('layouts.user')

@section('main-content')
<div>

    @php
        $status = $link->status ?? 'accepted';
        $badgeClasses = [
            'accepted' => 'bg-green-50 text-green-700',
            'pending' => 'bg-yellow-50 text-yellow-700',
            'rejected' => 'bg-red-50 text-red-700',
        ][$status] ?? 'bg-gray-50 text-gray-700';
    @endphp

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $doctor->full_name }}</h1>
                <p class="text-gray-600 mt-1">{{ $doctor->email }}</p>
                <span class="inline-flex items-center px-2 py-1 rounded text-xs mt-3 {{ $badgeClasses }}">{{ ucfirst($status) }}</span>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Doctor Profile Card -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Doctor Profile</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Details</h3>
                    <dl class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                        <dt class="text-gray-500">Title</dt><dd>{{ optional($profile)->title ?? '—' }}</dd>
                        <dt class="text-gray-500">Phone</dt><dd>{{ optional($profile)->phone_number ?? '—' }}</dd>
                        <dt class="text-gray-500">Website</dt>
                        <dd>
                            @if(optional($profile)->website)
                                <a class="text-sky-700 hover:underline" href="{{ optional($profile)->website }}" target="_blank">{{ optional($profile)->website }}</a>
                            @else
                                —
                            @endif
                        </dd>
                        <dt class="text-gray-500">Minimum Monthly Payment</dt><dd>{{ optional($profile)->minimum_monthly_payment ? '$' . number_format($profile->minimum_monthly_payment, 2) : '—' }}</dd>
                    </dl>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Practice Address</h3>
                    @if($address)
                        <div class="text-sm text-gray-700">
                            <div>{{ $address->label }}</div>
                            <div>{{ $address->address_line_1 }}</div>
                            @if($address->address_line_2)
                                <div>{{ $address->address_line_2 }}</div>
                            @endif
                            <div>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</div>
                            <div>{{ $address->country }}</div>
                        </div>
                    @else
                        <div class="text-sm text-gray-500">—</div>
                    @endif
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Bio</h3>
                    <div class="text-sm text-gray-700">{{ optional($profile)->bio ?? '—' }}</div>
                </div>
            </div>
        </div>

        <!-- Options -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Practice Options</h2>
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Transfer Types</h3>
                    <div class="text-sm text-gray-700">@if($profile && $profile->transferTypes && $profile->transferTypes->count()) {{ $profile->transferTypes->pluck('name')->join(', ') }} @else — @endif</div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Insurance Providers</h3>
                    <div class="text-sm text-gray-700">@if($profile && $profile->insuranceProviders && $profile->insuranceProviders->count()) {{ $profile->insuranceProviders->pluck('name')->join(', ') }} @else — @endif</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Reports From {{ $doctor->full_name }}</h2>
        @if(($documents ?? collect())->isEmpty())
            <div class="text-gray-500">No reports yet.</div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Uploaded</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($documents as $doc)
                    <tr>
                        <td class="px-4 py-2 align-top">
                            <div class="font-medium text-gray-900">{{ $doc->title }}</div>
                            @if($doc->comments)
                                <div class="text-sm text-gray-600 mt-1">{{ $doc->comments }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-2 align-top text-gray-600">{{ $doc->file_name }}</td>
                        <td class="px-4 py-2 align-top text-gray-600">{{ $doc->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 align-top text-right whitespace-nowrap">
                            <a class="inline-flex items-center px-3 py-1.5 rounded-lg bg-sky-600 text-white hover:bg-sky-700" href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection

