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
                @include('dashboard.partials.header')
            </div>
        </div>
    </div>
</div>
@endsection 