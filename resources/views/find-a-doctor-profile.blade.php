@extends('layouts.app')

@section('content')
<section class="py-12">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
      <div class="p-6 lg:p-10">
        <div class="flex flex-col md:flex-row md:items-start gap-6">
          <img class="h-28 w-28 rounded-full object-cover border" src="{{ $doctor->profile_picture ? asset('storage/' . $doctor->profile_picture) : asset('images/default-avatar.png') }}" alt="{{ $doctor->full_name }}" />
          <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900">{{ $doctor->full_name }}</h1>
            <div class="mt-1 text-gray-600">{{ $doctor->doctorProfile?->title ?: 'Orthodontist' }}</div>
            @if($doctor->currentAddress)
              <div class="mt-4 text-sm text-gray-700">
                <div>{{ $doctor->currentAddress->address_line_1 }}</div>
                @if($doctor->currentAddress->address_line_2)
                  <div>{{ $doctor->currentAddress->address_line_2 }}</div>
                @endif
                <div>{{ $doctor->currentAddress->city }}, {{ $doctor->currentAddress->state }} {{ $doctor->currentAddress->postal_code }}</div>
              </div>
            @endif

            <div class="mt-4 flex items-center gap-2">
              @if($doctor->doctorProfile?->phone_number)
                <a href="tel:{{ $doctor->doctorProfile?->phone_number }}" class="btn-outline">Call</a>
              @endif
              @if($doctor->doctorProfile?->website)
                <a href="{{ $doctor->doctorProfile?->website }}" target="_blank" class="btn-primary">Website</a>
              @endif
            </div>
          </div>
        </div>

        @if($doctor->doctorProfile?->bio)
        <div class="mt-8">
          <h2 class="text-lg font-semibold text-gray-900 mb-2">About</h2>
          <p class="text-gray-700 leading-relaxed">{{ $doctor->doctorProfile->bio }}</p>
        </div>
        @endif

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <h3 class="text-lg font-semibold mb-2">Transfer Types</h3>
            <div class="flex flex-wrap gap-2">
              @forelse(($doctor->doctorProfile?->transferTypes ?? []) as $t)
                <span class="badge badge-secondary">{{ $t->name }}</span>
              @empty
                <span class="text-sm text-gray-500">No data</span>
              @endforelse
            </div>
          </div>
          <div>
            <h3 class="text-lg font-semibold mb-2">Insurance Providers</h3>
            <div class="flex flex-wrap gap-2">
              @forelse(($doctor->doctorProfile?->insuranceProviders ?? []) as $p)
                <span class="badge badge-secondary">{{ $p->name }}</span>
              @empty
                <span class="text-sm text-gray-500">No data</span>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

