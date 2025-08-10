@extends('layouts.user')

@section('main-content')
<div>

    @php
        $status = $link->status ?? 'pending';
        $badgeClasses = [
            'accepted' => 'bg-green-50 text-green-700',
            'pending' => 'bg-yellow-50 text-yellow-700',
            'rejected' => 'bg-red-50 text-red-700',
        ][$status] ?? 'bg-gray-50 text-gray-700';
    @endphp

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $patient->full_name }}</h1>
                <p class="text-gray-600 mt-1">{{ $patient->email }}</p>
                <span class="inline-flex items-center px-2 py-1 rounded text-xs mt-3 {{ $badgeClasses }}">{{ ucfirst($status) }}</span>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Reports</div>
                <div class="text-2xl font-semibold text-gray-900">{{ $documents->count() }}</div>
            </div>
        </div>

        <div class="mt-6 grid md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Personal</h3>
                <dl class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                    <dt class="text-gray-500">Age</dt><dd>{{ $profile->age ?? '—' }}</dd>
                    <dt class="text-gray-500">Radius to Drive</dt><dd>{{ $profile->radius_willing_to_drive ?? '—' }}</dd>
                    <dt class="text-gray-500">Moving Temporarily</dt><dd>{{ ($profile->moving_temporarily ?? false) ? 'Yes' : 'No' }}</dd>
                    <dt class="text-gray-500">Preferred Doctor Type</dt><dd>{{ $profile?->doctorType?->name ?? '—' }}</dd>
                </dl>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Current Treatment</h3>
                <dl class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                    <dt class="text-gray-500">Orthodontist</dt><dd>{{ $profile->current_orthodontist_name ?? '—' }}</dd>
                    <dt class="text-gray-500">Address</dt><dd>{{ $profile->orthodontist_address ?? '—' }}</dd>
                    <dt class="text-gray-500">Original Length</dt><dd>{{ $profile->original_treatment_length_months ? $profile->original_treatment_length_months . ' months' : '—' }}</dd>
                    <dt class="text-gray-500">Remaining Amount</dt><dd>{{ $profile->remaining_financial_amount ? '$' . number_format($profile->remaining_financial_amount, 2) : '—' }}</dd>
                </dl>
            </div>
        </div>

        <div class="mt-4 grid md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Treatments</h3>
                <div class="text-sm text-gray-700">@if($profile && $profile->treatments && $profile->treatments->count()) {{ $profile->treatments->pluck('name')->join(', ') }} @else — @endif</div>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Functional Appliances</h3>
                <div class="text-sm text-gray-700">@if($profile && $profile->functionalAppliances && $profile->functionalAppliances->count()) {{ $profile->functionalAppliances->pluck('name')->join(', ') }} @else — @endif</div>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-2">TADs</h3>
                <div class="text-sm text-gray-700">@if($profile && $profile->tads && $profile->tads->count()) {{ $profile->tads->pluck('name')->join(', ') }} @else — @endif</div>
            </div>
        </div>

        @if($status === 'accepted')
        <div class="mt-6">
            <button x-data x-on:click="$dispatch('open-ortho-modal')" class="inline-flex items-center px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700">Edit Ortho Details</button>
        </div>
        @endif
    </div>

    <!-- Upload Form (Full Width) -->
    <div class="mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Upload Report</h2>
            <form method="POST" action="{{ route('dashboard.patients.upload', $patient->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Report Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500" placeholder="e.g., Panoramic X-ray Report">
                    @error('title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Report Notes</label>
                    <textarea name="comments" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500" placeholder="Notes about this report (optional)">{{ old('comments') }}</textarea>
                    @error('comments')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div x-data='{
                        isDragging: false,
                        files: [],
                        handleDrop(e) {
                            const dropped = Array.from(e.dataTransfer.files || []);
                            const input = this.$refs.fileInput;
                            const dt = new DataTransfer();
                            // keep any already-selected files
                            Array.from(input.files || []).forEach(f => dt.items.add(f));
                            dropped.forEach(f => dt.items.add(f));
                            input.files = dt.files;
                            this.files = Array.from(input.files);
                            this.isDragging = false;
                        },
                        handlePick(e) {
                            this.files = Array.from(e.target.files || []);
                        }
                    }'>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Report Files</label>
                    <input x-ref="fileInput" type="file" name="files[]" multiple required class="hidden" @change="handlePick($event)">
                    <div @click="$refs.fileInput.click()"
                         @dragover.prevent="isDragging = true"
                         @dragleave.prevent="isDragging = false"
                         @drop.prevent="handleDrop($event)"
                         :class="isDragging ? 'ring-2 ring-sky-400' : ''"
                         class="w-full border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-sky-300 transition-colors">
                        <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6H16a4 4 0 010 8h-1m-4-4v10m0 0l-3-3m3 3l3-3" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-700"><span class="font-medium text-sky-700">Click to browse</span> or drag and drop files here</p>
                        <p class="text-xs text-gray-500 mt-1">You can select multiple files. Max 10MB per file.</p>
                    </div>
                    <template x-if="files.length">
                        <ul class="mt-3 text-sm text-gray-700 space-y-1 text-left">
                            <template x-for="file in files" :key="file.name + file.size">
                                <li class="flex items-center justify-between">
                                    <span x-text="file.name"></span>
                                    <span class="text-xs text-gray-500" x-text="(file.size/1024).toFixed(0) + ' KB'"></span>
                                </li>
                            </template>
                        </ul>
                    </template>
                    @error('files.*')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="inline-flex items-center cursor-pointer px-5 py-2.5 rounded-lg bg-sky-600 text-white hover:bg-sky-700">Upload Report</button>
            </form>
        </div>
    </div>

    <!-- Reports Table (Full Width) -->
    <div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Reports</h2>
            @if($documents->isEmpty())
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

    <!-- Ortho Edit Modal -->
    @if(($link->status ?? 'pending') === 'accepted')
    <div x-data="{ open: false }" x-on:open-ortho-modal.window="open = true" x-show="open" class="fixed inset-0 z-50" style="display:none">
        <div class="absolute inset-0 bg-black/30" @click="open = false"></div>
        <div class="relative max-w-3xl mx-auto bg-white rounded-2xl shadow-lg mt-24 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Edit Ortho Details</h3>
                <button class="text-gray-500 hover:text-gray-700" @click="open = false">✕</button>
            </div>
            <form method="POST" action="{{ route('dashboard.patients.ortho.update', $patient->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                        <input type="number" name="age" value="{{ old('age', $profile->age ?? '') }}" min="1" max="120" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Radius to Drive (miles)</label>
                        <input type="number" name="radius_willing_to_drive" value="{{ old('radius_willing_to_drive', $profile->radius_willing_to_drive ?? '') }}" min="1" max="500" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="md:col-span-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="moving_temporarily" value="1" {{ old('moving_temporarily', $profile->moving_temporarily ?? false) ? 'checked' : '' }} class="h-4 w-4 text-sky-600 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Moving Temporarily</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Orthodontist</label>
                        <input type="text" name="current_orthodontist_name" value="{{ old('current_orthodontist_name', $profile->current_orthodontist_name ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Orthodontist Address</label>
                        <input type="text" name="orthodontist_address" value="{{ old('orthodontist_address', $profile->orthodontist_address ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Original Length (months)</label>
                        <input type="number" name="original_treatment_length_months" value="{{ old('original_treatment_length_months', $profile->original_treatment_length_months ?? '') }}" min="1" max="120" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Remaining Amount (USD)</label>
                        <input type="number" step="0.01" name="remaining_financial_amount" value="{{ old('remaining_financial_amount', $profile->remaining_financial_amount ?? '') }}" min="0" max="99999.99" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Doctor Type</label>
                        <select name="doctor_type_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">Select a doctor type...</option>
                            @foreach($doctorTypes as $doctorType)
                                <option value="{{ $doctorType->id }}" {{ old('doctor_type_id', $profile->doctor_type_id ?? '') == $doctorType->id ? 'selected' : '' }}>{{ $doctorType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Treatments</label>
                        <div class="space-y-1 max-h-40 overflow-auto border rounded-lg p-2">
                            @foreach($treatments as $t)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="treatments[]" value="{{ $t->id }}" {{ in_array($t->id, old('treatments', $profile?->treatments?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }} class="h-4 w-4 text-sky-600 border-gray-300 rounded">
                                    <span>{{ $t->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Functional Appliances</label>
                        <div class="space-y-1 max-h-40 overflow-auto border rounded-lg p-2">
                            @foreach($functionalAppliances as $fa)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="functional_appliances[]" value="{{ $fa->id }}" {{ in_array($fa->id, old('functional_appliances', $profile?->functionalAppliances?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }} class="h-4 w-4 text-sky-600 border-gray-300 rounded">
                                    <span>{{ $fa->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">TADs</label>
                        <div class="space-y-1 max-h-40 overflow-auto border rounded-lg p-2">
                            @foreach($tads as $tad)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="tads[]" value="{{ $tad->id }}" {{ in_array($tad->id, old('tads', $profile?->tads?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }} class="h-4 w-4 text-sky-600 border-gray-300 rounded">
                                    <span>{{ $tad->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="open = false" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-sky-600 text-white hover:bg-sky-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection

