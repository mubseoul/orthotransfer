@extends('layouts.app')

@section('content')
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(empty($zip))
        <div class="bg-white rounded-lg shadow-lg overflow-hidden" id="hero-section">
            <div class="lg:grid lg:grid-cols-2 lg:gap-0">
                <!-- Left: Copy + Form -->
                <div class="px-8 py-12 lg:px-12 lg:py-16">
                    <span class="badge badge-primary">Find a doctor</span>
                    <h1 class="mt-3 text-3xl lg:text-4xl font-bold text-heading leading-tight">Find your nearest orthodontist</h1>
                    <p class="mt-3 text-body">Enter your ZIP code and select the patient's age to get matched with doctors near you.</p>

                    <div class="mt-6 space-y-3">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-sky-100 text-sky-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Seamless Transfers</p>
                                <p class="text-sm text-gray-500">Continue your treatment without missing a beat</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-sky-100 text-sky-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Verified Doctors</p>
                                <p class="text-sm text-gray-500">Connect with licensed, experienced orthodontists</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-sky-100 text-sky-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Local Options</p>
                                <p class="text-sm text-gray-500">Find doctors near you for convenient appointments</p>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('find-doctor') }}" class="mt-8 max-w-md">
                        <!-- ZIP CODE -->
                        <label class="block text-xs font-semibold text-gray-700 tracking-wide">ZIP CODE</label>
                        <div class="mt-2 relative">
                            <input id="zip-input" type="text" name="zip" value="{{ old('zip', $zip) }}" placeholder="44000" required class="w-full h-12 rounded-full border border-gray-300 pl-12 pr-12 focus:ring-2 focus:border-transparent" style="box-shadow: 0 0 0 1px transparent;" />
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
                            <p class="mt-2 text-xs text-muted">We only use your location to detect your ZIP code.</p>
                        </div>
                    </form>
                </div>

                <!-- Right: Image/Visual -->
                <div class="bg-gray-100">
                    <img src="https://www.fulhamroaddental.com/wp-content/uploads/2023/07/AdobeStock_206395820-scaled.jpeg" alt="Orthodontic consultation" class="h-64 lg:h-full w-full object-cover" />
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
@php
    $doctorData = [];
    if (isset($doctors) && $doctors) {
        foreach ($doctors as $d) {
            $address = $d->currentAddress;
            $imageUrl = $d->profile_picture
                ? asset('storage/' . $d->profile_picture)
                : asset('images/default-avatar.png');
            $doctorData[] = [
                'id' => $d->id,
                'name' => $d->full_name,
                'title' => optional($d->doctorProfile)->title,
                'phone' => optional($d->doctorProfile)->phone_number,
                'website' => optional($d->doctorProfile)->website,
                'image' => $imageUrl,
                'address' => $address ? [
                    'address_line_1' => $address->address_line_1,
                    'address_line_2' => $address->address_line_2,
                    'city' => $address->city,
                    'state' => $address->state,
                    'postal_code' => $address->postal_code,
                    'latitude' => $address->latitude,
                    'longitude' => $address->longitude,
                ] : null,
            ];
        }
    }
@endphp
@if(($zip ?? '') !== '')
<!-- Leaflet CSS & JS -->
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
  crossorigin=""
/>
<script
  src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
  crossorigin=""
></script>
@endif
<script>
document.addEventListener('DOMContentLoaded', () => {
  const button = document.getElementById('use-my-location');
  const zipInput = document.getElementById('zip-input');
  const helper = document.getElementById('zip-helper');

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

  if (button && zipInput) {
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
  }

      // If a ZIP has been searched, transform the hero into results layout with map + list
  const searchedZip = @json($zip ?? '');
  const doctors = @json($doctorData);
  const currentAge = @json($age ?? '20_plus');
  const currentSort = @json($sort ?? 'name_asc');
  const currentQ = @json($q ?? '');
      const profileBase = @json(route('find-doctor.profile', [], false));

  if (searchedZip) {
    // Build results shell after the hero card
    const host = document.querySelector('section.py-16 > div');
    if (host) {
      // Hide hero section if present
      const hero = document.getElementById('hero-section');
      if (hero) hero.classList.add('hidden');

      // Results header bar card with inline search + filters
      const header = document.createElement('div');
      header.className = 'mb-4';
      header.innerHTML = `
        <div class=\"card p-4\">
          <form method=\"GET\" action=\"${window.location.pathname}\" class=\"grid grid-cols-1 md:grid-cols-12 gap-3 items-end\">
            <div class=\"md:col-span-5\">
              <label class=\"form-label\">ZIP Code<\/label>
              <div class=\"relative\">
                <input type=\"text\" name=\"zip\" value=\"${searchedZip}\" class=\"form-input pl-10\" placeholder=\"44000\" required/>
                <svg class=\"absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z\" /><\/svg>
              <\/div>
              <input type=\"hidden\" name=\"sort\" value=\"${currentSort}\" />
              <input type=\"hidden\" name=\"q\" value=\"${currentQ}\" />
            </div>
            <div class=\"md:col-span-4\">
              <label class=\"form-label\">Patient's age<\/label>
              <div class=\"flex gap-3\">
                <label class=\"flex items-center gap-2 px-3 py-2 rounded-lg border cursor-pointer ${currentAge==='under_20' ? 'border-yellow-600 bg-primary-50' : 'border-gray-300 hover:border-gray-400'}\"><input type=\"radio\" name=\"age\" value=\"under_20\" class=\"form-radio\" ${currentAge==='under_20' ? 'checked' : ''}><span class=\"text-sm\">Under 20<\/span><\/label>
                <label class=\"flex items-center gap-2 px-3 py-2 rounded-lg border cursor-pointer ${currentAge==='20_plus' ? 'border-yellow-600 bg-primary-50' : 'border-gray-300 hover:border-gray-400'}\"><input type=\"radio\" name=\"age\" value=\"20_plus\" class=\"form-radio\" ${currentAge==='20_plus' ? 'checked' : ''}><span class=\"text-sm\">20 +<\/span><\/label>
              </div>
            </div>
            <div class=\"md:col-span-3 flex gap-2\">
              <button type=\"submit\" class=\"btn-primary w-full md:w-auto\">Search<\/button>
              <button type=\"button\" id=\"open-filters\" class=\"btn-outline w-full md:w-auto\">Filters<\/button>
            </div>
          <\/form>

          <div class=\"mt-3 flex items-center gap-2 text-sm text-gray-600\">
            <span class=\"badge badge-secondary\">ZIP: ${searchedZip}<\/span>
            <span class=\"badge badge-secondary\">${doctors.length} result${doctors.length===1?'':'s'}<\/span>
          </div>
        <\/div>

        <div id=\"filters-modal\" class=\"fixed inset-0 z-50 hidden\">
          <div class=\"absolute inset-0 bg-black/40\"></div>
          <div class=\"relative mx-auto mt-24 max-w-lg w-[92%]\">
            <div class=\"bg-white rounded-lg shadow-lg border border-gray-200 p-6\">
              <div class=\"flex items-center justify-between mb-4\">
                <h3 class=\"text-lg font-semibold\">Filter & Search<\/h3>
                <button id=\"close-filters\" class=\"text-gray-500 hover:text-gray-700\">✕<\/button>
              </div>
              <form method=\"GET\" action=\"${window.location.pathname}\" class=\"space-y-4\">
                <div>
                  <label class=\"form-label\">ZIP Code<\/label>
                  <input type=\"text\" name=\"zip\" value=\"${searchedZip}\" class=\"form-input\" placeholder=\"44000\" required />
                </div>
                <div>
                  <label class=\"form-label\">Doctor name (optional)<\/label>
                  <input type=\"text\" name=\"q\" value=\"${new URLSearchParams(window.location.search).get('q') || ''}\" class=\"form-input\" placeholder=\"e.g., Johnson\" />
                </div>
                <div>
                  <label class=\"form-label\">Patient's age<\/label>
                  <div class=\"flex gap-3\">
                    <label class=\"inline-flex items-center gap-2\"><input type=\"radio\" name=\"age\" value=\"under_20\" class=\"form-radio\" ${currentAge==='under_20' ? 'checked' : ''}><span>Under 20<\/span></label>
                    <label class=\"inline-flex items-center gap-2\"><input type=\"radio\" name=\"age\" value=\"20_plus\" class=\"form-radio\" ${currentAge==='20_plus' ? 'checked' : ''}><span>20 +<\/span></label>
                  </div>
                </div>
                <div>
                  <label class=\"form-label\">Sort<\/label>
                  <select name=\"sort\" class=\"form-select\">
                    <option value=\"name_asc\" ${currentSort==='name_asc' ? 'selected' : ''}>Name A → Z<\/option>
                    <option value=\"name_desc\" ${currentSort==='name_desc' ? 'selected' : ''}>Name Z → A<\/option>
                  <\/select>
                </div>
                <div class=\"pt-2 flex justify-end gap-2\">
                  <button type=\"button\" id=\"close-filters-2\" class=\"btn-secondary\">Cancel<\/button>
                  <button class=\"btn-primary\" type=\"submit\">Search<\/button>
                </div>
              </form>
            </div>
          </div>
        </div>
      `;
      host.appendChild(header);

      // Modal handlers
      const modal = header.querySelector('#filters-modal');
      header.querySelector('#open-filters').addEventListener('click', ()=> modal.classList.remove('hidden'));
      header.querySelector('#close-filters').addEventListener('click', ()=> modal.classList.add('hidden'));
      header.querySelector('#close-filters-2').addEventListener('click', ()=> modal.classList.add('hidden'));
      const wrapper = document.createElement('div');
      wrapper.className = 'grid grid-cols-1 lg:grid-cols-12 gap-4';
      wrapper.innerHTML = `
        <div class="lg:col-span-4 space-y-3" id="doctor-list"></div>
        <div class="lg:col-span-8">
          <div id="doctor-map" class="w-full h-[600px] rounded-lg border border-gray-200"></div>
        </div>
      `;
      host.appendChild(wrapper);

      // Render list
      const list = wrapper.querySelector('#doctor-list');
      if (doctors.length === 0) {
        const empty = document.createElement('div');
        empty.className = 'card p-4 text-sm text-gray-600';
        empty.textContent = 'No doctors found for your search. Try adjusting your ZIP code or age.';
        list.appendChild(empty);
      } else {
        doctors.forEach((d) => {
          const addr = d.address;
          const card = document.createElement('div');
          card.className = 'rounded-xl border-2 border-sky-200 bg-white shadow-sm p-5 cursor-pointer transition';
          card.dataset.id = String(d.id);
          if (addr && addr.latitude && addr.longitude) {
            card.dataset.lat = String(addr.latitude);
            card.dataset.lon = String(addr.longitude);
          }
          card.innerHTML = `
            <div class="flex items-start gap-4">
              <div class="relative">
                <img src="${d.image}" alt="${d.name}" class="h-20 w-20 rounded-full object-cover border" />
                <span class="absolute -bottom-1 -right-1 h-6 w-6 rounded-full bg-yellow-200 border border-yellow-300 flex items-center justify-center text-yellow-700 text-xs">★</span>
              </div>
              <div class="min-w-0 flex-1">
                <div class="text-gray-900 font-semibold">${d.name}</div>
                <div class="mt-0.5 text-sm text-gray-600">${d.title || 'Orthodontist'} <span class="mx-1">|</span> <span class="badge badge-secondary">Verified</span></div>
                <div class="mt-2 text-sm text-gray-600">
                  ${addr ? `${addr.address_line_1 || ''}${addr.address_line_2 ? '<br/>'+addr.address_line_2 : ''}<br/>${addr.city || ''}, ${addr.state || ''} ${addr.postal_code || ''}` : 'No address'}
                </div>
                <div class="mt-4 pt-3 flex items-center justify-between border-t border-gray-100">
                  ${d.phone ? `<a href=\"tel:${d.phone}\" class=\"inline-flex items-center gap-2 text-sky-700 hover:text-sky-800 font-medium\"><svg class=\"h-5 w-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3 5a2 2 0 012-2h2.28a1 1 0 01.948.684l1.498 4.494a1 1 0 01-.502 1.21l-1.27.635a16.001 16.001 0 007.226 7.226l.635-1.27a1 1 0 011.21-.502l4.494 1.498A1 1 0 0121 19.72V22a2 2 0 01-2 2h-1C9.163 24 0 14.837 0 3V2a2 2 0 012-2h2z\" /></svg>${d.phone}</a>` : '<span></span>'}
                </div>
              </div>
            </div>
          `;
          list.appendChild(card);
        });
      }

      // Compute miles away after rendering list
      (function computeMiles(){
        const toRad = (d)=> d*Math.PI/180;
        const distanceMiles = (lat1,lon1,lat2,lon2)=>{
          const R=3958.8, dLat=toRad(lat2-lat1), dLon=toRad(lon2-lon1);
          const a=Math.sin(dLat/2)**2 + Math.cos(toRad(lat1))*Math.cos(toRad(lat2))*Math.sin(dLon/2)**2;
          return R*2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a));
        };
        fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&postalcode=${encodeURIComponent(searchedZip)}&countrycodes=us`)
          .then(r=>r.json())
          .then(rows=>{
            const c=rows && rows[0]; if(!c) return;
            const zipLat=parseFloat(c.lat), zipLon=parseFloat(c.lon);
            list.querySelectorAll('[data-id]').forEach(card=>{
              const lat=parseFloat(card.dataset.lat||'NaN');
              const lon=parseFloat(card.dataset.lon||'NaN');
              if(!isNaN(lat)&&!isNaN(lon)){
                const m=distanceMiles(zipLat,zipLon,lat,lon);
                const addrDiv=card.querySelector('.mt-2.text-sm.text-gray-600');
                if(addrDiv){
                  const milesDiv=document.createElement('div');
                  milesDiv.className='mt-1 flex items-center gap-1 text-[12px] text-gray-600';
                  milesDiv.innerHTML='<svg class="h-4 w-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>'+m.toFixed(1)+' miles away';
                  addrDiv.parentElement.insertBefore(milesDiv, addrDiv);
                }
              }
            });
          }).catch(()=>{});
      })();

      // Init map centered by first doctor with coordinates if available; else geocode ZIP
      const mapEl = wrapper.querySelector('#doctor-map');
      let map;
      const markerById = new Map();
      function setupListInteractions() {
        const cards = list.querySelectorAll('.rounded-xl');
        let selected;
        cards.forEach(c => {
          c.addEventListener('click', () => {
            const id = c.dataset.id;
            const marker = markerById.get(Number(id)) || markerById.get(id);
            if (selected) selected.classList.remove('ring-2','ring-sky-400');
            selected = c;
            c.classList.add('ring-2','ring-sky-400');
            if (marker && map) {
              map.setView(marker.getLatLng(), 13, { animate: true });
              marker.openPopup();
            }
          });
        });
      }

      function initMap(lat, lng) {
        if (map) return;
        map = L.map(mapEl).setView([lat, lng], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '© OpenStreetMap'
        }).addTo(map);

        const bounds = [];
        doctors.forEach(d => {
          const a = d.address;
          if (a && a.latitude && a.longitude) {
            const m = L.marker([a.latitude, a.longitude]).addTo(map);
            const addressBlock = `${a.address_line_1 || ''}${a.address_line_2 ? '<br/>'+a.address_line_2 : ''}<br/>${a.city || ''}, ${a.state || ''} ${a.postal_code || ''}`;
            const directionsUrl = `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(`${a.address_line_1 || ''} ${a.address_line_2 || ''}, ${a.city || ''}, ${a.state || ''} ${a.postal_code || ''}`)}`;
            const website = d.id ? `${profileBase}?profile=${encodeURIComponent(d.id)}` : (d.website || '#');
            const phoneHtml = d.phone ? `<a href=\"tel:${d.phone}\" style=\"display:inline-flex;align-items:center;gap:6px;color:#0284c7;font-weight:500;font-size:12px;\"><svg width=\"16\" height=\"16\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.11 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.81.3 1.6.57 2.34a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.74-1.14a2 2 0 0 1 2.11-.45c.74.27 1.53.45 2.34.57A2 2 0 0 1 22 16.92z\"/></svg>${d.phone}</a>` : '<span></span>';
            const popupHtml = `
              <div style=\"min-width:280px;\">
                <div style=\"font-weight:700;color:#111827;text-transform:uppercase;font-size:14px;\">${d.name}</div>
                <div style=\"margin-top:4px;font-size:12px;color:#374151;\">${d.title || 'Orthodontist'} | <a href=\"${website}\" style=\"color:#2563eb;text-decoration:underline;\">View Profile</a></div>
                <div style=\"margin-top:8px;font-size:12px;color:#374151;\">${addressBlock}</div>
                <div style=\"margin-top:6px;font-size:12px;\"><a href=\"${directionsUrl}\" target=\"_blank\" style=\"color:#2563eb;text-decoration:underline;\">directions</a></div>
                <div style=\"margin-top:12px;display:flex;justify-content:flex-start;align-items:center;gap:8px;\">${phoneHtml}</div>
              </div>
            `;
            m.bindPopup(popupHtml);
            markerById.set(Number(d.id), m);
            m.on('click', () => {
              const card = list.querySelector(`[data-id="${d.id}"]`);
              if (card) {
                list.querySelectorAll('[data-id]').forEach(x => x.classList.remove('ring-2','ring-sky-400'));
                card.classList.add('ring-2','ring-sky-400');
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
              }
            });
            bounds.push([a.latitude, a.longitude]);
          }
        });
        if (bounds.length > 0) {
          map.fitBounds(bounds, { padding: [20, 20] });
        }
        setupListInteractions();
      }

      // Prefer coordinates from doctors if present
      const firstWithCoords = doctors.find(d => d.address && d.address.latitude && d.address.longitude);
      if (firstWithCoords) {
        initMap(firstWithCoords.address.latitude, firstWithCoords.address.longitude);
      } else {
        // Forward geocode ZIP to center the map
        fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&postalcode=${encodeURIComponent(searchedZip)}&countrycodes=us`)
          .then(r => r.json())
          .then(rows => {
            const c = rows && rows[0];
            if (c) initMap(parseFloat(c.lat), parseFloat(c.lon));
            else initMap(40.0, -95.0); // USA fallback
          })
          .catch(() => initMap(40.0, -95.0));
      }
    }
  }
});
</script>
@endpush

