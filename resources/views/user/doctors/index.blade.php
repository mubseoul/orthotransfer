@extends('layouts.user')

@section('main-content')
<div>
    <h1 class="text-2xl font-semibold mb-6">My Doctors</h1>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        @if($doctors->isEmpty())
            <p class="text-gray-500">No doctors yet.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($doctors as $d)
                        @php($link = $links[$d->id] ?? null)
                        @php($status = $link->status ?? 'pending')
                        @php($badge = $status === 'accepted' ? 'bg-green-50 text-green-700' : ($status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700'))
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $d->full_name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-gray-600">{{ $d->email }}</td>
                            <td class="px-4 py-2 whitespace-nowrap"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ $badge }}">{{ ucfirst($status) }}</span></td>
                            <td class="px-4 py-2 whitespace-nowrap text-right">
                                <div class="flex items-center gap-2 justify-end">
                                    @if($status === 'accepted')
                                        <a href="{{ route('dashboard.doctors.show', $d->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-sky-600 text-white hover:bg-sky-700">View Profile</a>
                                    @endif
                                    @if($status === 'pending')
                                        <form method="POST" action="{{ route('dashboard.doctors.respond', $d->id) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="accept">
                                            <button class="px-3 py-1.5 rounded-lg bg-green-600 text-white hover:bg-green-700">Accept</button>
                                        </form>
                                        <form method="POST" action="{{ route('dashboard.doctors.respond', $d->id) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button class="px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700">Reject</button>
                                        </form>
                                    @endif
                                </div>
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

