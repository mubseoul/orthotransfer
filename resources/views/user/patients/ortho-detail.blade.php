@extends('layouts.user')

@section('main-content')
<div>
    <a href="{{ route('dashboard.patients.show', $patient->id) }}" class="inline-flex items-center text-sm text-sky-700 hover:text-sky-800">← Back</a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Edit Ortho Details for {{ $patient->full_name }}</h1>
        <p class="text-gray-600 mt-1">Only available because the patient accepted your request.</p>
    </div>

    @include('user.ortho-detail', ['user' => $doctor])
</div>
@endsection

