@extends('layouts.app')

@section('content')
<section class="section-padding">
    <div class="container-app">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <!-- Left: Copy + Form -->
            <div>
                <div class="text-sm font-semibold tracking-wider text-sky-700 uppercase">Find a doctor</div>
                <h1 class="mt-2 text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    Locate your nearest<br class="hidden md:block"/> doctor.
                </h1>
                <p class="mt-4 text-gray-600 max-w-xl">Learn about the duration and cost of your treatment.
                    Enter your ZIP code and select the patient's age to get started.</p>

                <form method="GET" action="{{ route('find-doctor') }}" class="mt-8 max-w-md">
                    <!-- ZIP CODE -->
                    <label class="block text-xs font-semibold text-gray-700 tracking-wide">ZIP CODE</label>
                    <div class="mt-2 relative">
                        <input id="zip-input" type="text" name="zip" value="{{ old('zip', $zip) }}" placeholder="44000" class="w-full h-12 rounded-full border border-gray-300 pl-12 pr-12 focus:ring-2 focus:ring-sky-500 focus:border-sky-500" />
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                        <button id="use-my-location" type="button" class="absolute right-2 top-1/2 -translate-y-1/2 h-8 w-8 rounded-full border border-gray-300 bg-white flex items-center justify-center text-gray-500 hover:text-gray-700" title="Use my location">
                            <svg width="21.9" height="21.9" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 22.4501V20.4501C7.91672 20.2167 6.12938 19.3544 4.63805 17.8631C3.14605 16.3711 2.28338 14.5834 2.05005 12.5H0.0500488V10.5H2.05005C2.28338 8.41672 3.14605 6.62905 4.63805 5.13705C6.12938 3.64572 7.91672 2.78338 10 2.55005V0.550049H12V2.55005C14.0834 2.78338 15.8711 3.64572 17.3631 5.13705C18.8544 6.62905 19.7167 8.41672 19.9501 10.5H21.9501V12.5H19.9501C19.7167 14.5834 18.8544 16.3711 17.3631 17.8631C15.8711 19.3544 14.0834 20.2167 12 20.4501V22.4501H10ZM11 18.5C12.9334 18.5 14.5834 17.8167 15.95 16.45C17.3167 15.0834 18 13.4334 18 11.5C18 9.56672 17.3167 7.91672 15.95 6.55005C14.5834 5.18338 12.9334 4.50005 11 4.50005C9.06672 4.50005 7.41672 5.18338 6.05005 6.55005C4.68338 7.91672 4.00005 9.56672 4.00005 11.5C4.00005 13.4334 4.68338 15.0834 6.05005 16.45C7.41672 17.8167 9.06672 18.5 11 18.5ZM11 15.5C9.90005 15.5 8.95838 15.1084 8.17505 14.325C7.39172 13.5417 7.00005 12.6 7.00005 11.5C7.00005 10.4 7.39172 9.45838 8.17505 8.67505C8.95838 7.89172 9.90005 7.50005 11 7.50005C12.1 7.50005 13.0417 7.89172 13.825 8.67505C14.6084 9.45838 15 10.4 15 11.5C15 12.6 14.6084 13.5417 13.825 14.325C13.0417 15.1084 12.1 15.5 11 15.5Z" fill="#3D3935"></path></svg>
                        </button>
                    </div>
                    <p id="zip-helper" class="mt-2 text-sm text-gray-500 hidden"></p>

                    <!-- AGE -->
                    <div class="mt-6">
                        <label class="block text-xs font-semibold text-gray-700 tracking-wide">PATIENT'S AGE</label>
                        <div class="mt-3 flex items-center gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="radio" name="age" value="under_20" class="form-radio" {{ $age === 'under_20' ? 'checked' : '' }}>
                                <span class="text-gray-700">Under 20</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="radio" name="age" value="20_plus" class="form-radio" {{ $age === '20_plus' ? 'checked' : '' }}>
                                <span class="text-gray-700">20 +</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full h-12 rounded-full btn-primary text-base">Find a doctor now</button>
                    </div>
                </form>
            </div>

            <!-- Right: Image -->
            <div class="hidden lg:block">
                <img src="https://images.unsplash.com/photo-1588771930290-bf6362a06c64?q=80&w=1600&auto=format&fit=crop" alt="Orthodontic consultation" class="rounded-2xl shadow-lg w-full h-[440px] object-cover" />
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const button = document.getElementById('use-my-location');
  const zipInput = document.getElementById('zip-input');
  const helper = document.getElementById('zip-helper');

  if (!button || !zipInput) return;

  async function reverseGeocode(lat, lon) {
    // OpenStreetMap Nominatim reverse geocoding (no API key needed; suitable for light usage)
    const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}&addressdetails=1`;
    const resp = await fetch(url, {
      headers: { 'Accept': 'application/json' }
    });
    if (!resp.ok) throw new Error('Reverse geocoding failed');
    return resp.json();
  }

  function setStatus(message, isError = false) {
    if (!helper) return;
    helper.textContent = message || '';
    helper.classList.toggle('hidden', !message);
    helper.classList.toggle('text-red-600', !!isError);
    helper.classList.toggle('text-gray-500', !isError);
  }

  button.addEventListener('click', async () => {
    if (!navigator.geolocation) {
      setStatus('Geolocation is not supported by your browser.', true);
      return;
    }
    setStatus('Detecting your location…');
    button.disabled = true;
    try {
      const position = await new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject, { enableHighAccuracy: true, timeout: 10000 });
      });
      const { latitude, longitude } = position.coords;
      setStatus('Fetching your ZIP code…');
      const data = await reverseGeocode(latitude, longitude);
      const zip = data?.address?.postcode || '';
      if (zip) {
        zipInput.value = zip;
        setStatus(`Detected ZIP: ${zip}`);
      } else {
        setStatus('Could not determine ZIP code for your location.', true);
      }
    } catch (err) {
      setStatus('Unable to get your location. Please allow permission or enter ZIP manually.', true);
    } finally {
      button.disabled = false;
    }
  });
});
</script>
@endpush

