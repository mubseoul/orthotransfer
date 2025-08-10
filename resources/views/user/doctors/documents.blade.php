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

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $doctor->full_name }}</h1>
            <p class="text-gray-600 mt-1">{{ $doctor->email }}</p>
            <span class="inline-flex items-center px-2 py-1 rounded text-xs mt-3 {{ $badgeClasses }}">{{ ucfirst($status) }}</span>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500">Reports</div>
            <div class="text-2xl font-semibold text-gray-900">{{ $documents->count() }}</div>
        </div>
    </div>

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
@endsection

