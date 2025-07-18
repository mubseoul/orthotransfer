@extends('admin.layouts.app')

@section('page-title', $option->exists ? 'Edit ' . $config['singular'] : 'Add ' . $config['singular'])

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                {{ $option->exists ? 'Edit ' . $config['singular'] : 'Add New ' . $config['singular'] }}
            </h2>
            <p class="text-slate-600 mt-1">
                {{ $option->exists ? 'Update the details for this ' . strtolower($config['singular']) : 'Create a new ' . strtolower($config['singular']) . ' for the platform' }}
            </p>
        </div>
        <a href="{{ route('admin.options.index', $type) }}" 
           class="inline-flex items-center px-4 py-2 text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium rounded-xl transition-colors duration-200 border border-slate-300">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to {{ $config['title'] }}
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">
                {{ $config['singular'] }} Information
            </h3>
        </div>

        <form method="POST" action="{{ $option->exists ? route('admin.options.update', [$type, $option->id]) : route('admin.options.store', $type) }}" class="p-6 space-y-6">
            @csrf
            @if($option->exists)
                @method('PUT')
            @endif

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $option->name) }}"
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('name') border-red-300 ring-red-500 @enderror"
                       placeholder="Enter {{ strtolower($config['singular']) }} name"
                       required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('description') border-red-300 ring-red-500 @enderror"
                          placeholder="Enter a brief description (optional)">{{ old('description', $option->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-slate-500">
                    Provide a helpful description to explain this {{ strtolower($config['singular']) }}.
                </p>
            </div>

            <!-- Status Field -->
            <div>
                <label for="is_active" class="block text-sm font-medium text-slate-700 mb-2">
                    Status
                </label>
                <div class="relative">
                    <select id="is_active" 
                            name="is_active"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 appearance-none bg-white @error('is_active') border-red-300 ring-red-500 @enderror">
                        <option value="1" {{ old('is_active', $option->is_active ?? true) ? 'selected' : '' }}>
                            Active - Available for selection
                        </option>
                        <option value="0" {{ old('is_active', $option->is_active ?? true) == false ? 'selected' : '' }}>
                            Inactive - Hidden from selection
                        </option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                @error('is_active')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-slate-500">
                    Active {{ strtolower($config['title']) }} will be available for users to select. Inactive ones will be hidden.
                </p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.options.index', $type) }}" 
                   class="px-6 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium rounded-xl transition-colors duration-200 border border-slate-300">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-sm">
                    @if($option->exists)
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update {{ $config['singular'] }}
                    @else
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create {{ $config['singular'] }}
                    @endif
                </button>
            </div>
        </form>
    </div>

    @if($option->exists)
        <!-- Additional Information Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Additional Information</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Created</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $option->created_at->format('F j, Y \a\t g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $option->updated_at->format('F j, Y \a\t g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Current Status</dt>
                        <dd class="mt-1">
                            @if($option->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Inactive
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">ID</dt>
                        <dd class="mt-1 text-sm text-slate-900">#{{ $option->id }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    @endif
</div>
@endsection 