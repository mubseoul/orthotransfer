@extends('layouts.user')

@section('main-content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $address->exists ? 'Edit Address' : 'Add Address' }}</h1>
            <p class="text-gray-600 mt-2">Enter your address details</p>
        </div>
        <a href="{{ route('dashboard.addresses.index') }}" class="text-sky-700 hover:underline">Back to Addresses</a>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $address->exists ? route('dashboard.addresses.update', $address->id) : route('dashboard.addresses.store') }}" class="space-y-6" id="address-form">
        @csrf
        @if($address->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                <input type="text" name="label" value="{{ old('label', $address->label) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                <input type="text" name="country" value="{{ old('country', $address->country) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Address line 1 *</label>
                <input type="text" name="address_line_1" id="autocomplete" value="{{ old('address_line_1', $address->address_line_1) }}" placeholder="Start typing address..." required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Address line 2</label>
                <input type="text" name="address_line_2" value="{{ old('address_line_2', $address->address_line_2) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                <input type="text" name="city" value="{{ old('city', $address->city) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                <input type="text" name="state" value="{{ old('state', $address->state) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Postal code *</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div class="md:col-span-2 grid grid-cols-1 gap-6">
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $address->latitude) }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $address->longitude) }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <div id="map" class="w-full rounded-xl border border-gray-200" style="height: 320px;"></div>
                    <p class="mt-2 text-xs text-gray-500">Search your address above, then drag the pin or click on the map to fine-tune the location.</p>
                </div>

                <div class="flex items-center">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_current" value="1" {{ old('is_current', $address->is_current) ? 'checked' : '' }} class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Set as current</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-sky-600 text-white font-medium rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">{{ $address->exists ? 'Update Address' : 'Save Address' }}</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function initGoogleMapsInternal() {
  const input = document.getElementById('autocomplete');
  const latInput = document.getElementById('latitude');
  const lngInput = document.getElementById('longitude');
  const mapEl = document.getElementById('map');

  if (!mapEl) return;

  // Setup default center
  let center = { lat: 37.773972, lng: -122.431297 }; // Fallback: San Francisco
  const latVal = parseFloat(latInput?.value);
  const lngVal = parseFloat(lngInput?.value);
  if (!isNaN(latVal) && !isNaN(lngVal)) {
    center = { lat: latVal, lng: lngVal };
  }

  // Initialize map and marker first
  const map = new google.maps.Map(mapEl, {
    center: center,
    zoom: 13,
    mapTypeControl: false,
    streetViewControl: false,
    fullscreenControl: false,
  });

  const marker = new google.maps.Marker({ position: center, map, draggable: true });

  // Geolocate if no coords preset
  if ((isNaN(latVal) || isNaN(lngVal)) && navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((pos) => {
      const userLoc = { lat: pos.coords.latitude, lng: pos.coords.longitude };
      map.setCenter(userLoc);
      marker.setPosition(userLoc);
      if (latInput) latInput.value = userLoc.lat;
      if (lngInput) lngInput.value = userLoc.lng;
    });
  }

  // Update hidden fields when marker moves or map is clicked
  marker.addListener('dragend', () => {
    const pos = marker.getPosition();
    if (latInput) latInput.value = pos.lat();
    if (lngInput) lngInput.value = pos.lng();
  });
  map.addListener('click', (e) => {
    marker.setPosition(e.latLng);
    if (latInput) latInput.value = e.latLng.lat();
    if (lngInput) lngInput.value = e.latLng.lng();
  });

  // Places Autocomplete with suggestions dropdown
  if (input && google.maps.places) {
    const autocomplete = new google.maps.places.Autocomplete(input, { types: ['geocode'] });
    autocomplete.addListener('place_changed', () => {
      const place = autocomplete.getPlace();
      if (!place || !place.address_components) return;

      const getComponent = (types) => {
        const comp = place.address_components.find(c => types.every(t => c.types.includes(t)));
        return comp ? comp.long_name : '';
      };

      const streetNumber = getComponent(['street_number']);
      const route = getComponent(['route']);
      const city = getComponent(['locality']) || getComponent(['postal_town']) || getComponent(['administrative_area_level_2']);
      const state = getComponent(['administrative_area_level_1']);
      const country = getComponent(['country']);
      const postalCode = getComponent(['postal_code']);

      document.querySelector('input[name="address_line_1"]').value = [streetNumber, route].filter(Boolean).join(' ') || input.value;
      document.querySelector('input[name="city"]').value = city;
      document.querySelector('input[name="state"]').value = state;
      document.querySelector('input[name="country"]').value = country;
      document.querySelector('input[name="postal_code"]').value = postalCode;

      if (place.geometry && place.geometry.location) {
        const loc = place.geometry.location;
        map.setCenter(loc);
        map.setZoom(15);
        marker.setPosition(loc);
        if (latInput) latInput.value = loc.lat();
        if (lngInput) lngInput.value = loc.lng();
      }
    });
  }
}

// Expose callback globally for Google loader
window.initGoogleMaps = function() {
  try {
    initGoogleMapsInternal();
  } catch (e) {
    console.error('Google Maps initialization failed', e);
  }
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&libraries=places&callback=initGoogleMaps"></script>
@endpush

