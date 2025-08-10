@extends('layouts.user')

@section('main-content')
<div>
    <h1 class="text-2xl font-semibold mb-6">My Patients</h1>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8">
        <form method="POST" action="{{ route('dashboard.patients.store') }}" class="space-y-4">
            @csrf
            <div class="md:flex md:items-end md:gap-4">
                <div class="flex-1">
                    <label for="invite_email" class="block text-sm font-medium text-gray-700 mb-2">Patient Email</label>
                    <input id="invite_email" type="email" name="email" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors"
                           placeholder="patient@example.com">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3 md:mt-0">
                    <button type="submit" class="px-6 py-3 bg-sky-600 text-white font-medium rounded-lg hover:bg-sky-700">Add Patient</button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl p-4 shadow">
        <h2 class="text-lg font-medium mb-4">Patients & Invitations</h2>
        @if($patients->isEmpty() && collect($pendingLinks)->isEmpty() && collect($emailInvites)->isEmpty())
            <p class="text-gray-500">No patients or invitations yet.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invited/Linked</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($patients as $p)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $p->full_name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-600">{{ $p->email }}</td>
                        <td class="px-4 py-2 whitespace-nowrap"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-green-50 text-green-700">Accepted</span></td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-600">{{ optional($p->pivot?->created_at)->format('M d, Y') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-right">
                            <a href="{{ route('dashboard.patients.show', $p->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-sky-600 text-white hover:bg-sky-700">View</a>
                        </td>
                    </tr>
                    @endforeach
                    @foreach($pendingLinks as $inv)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $inv->first_name }} {{ $inv->last_name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-600">{{ $inv->email }}</td>
                        <td class="px-4 py-2 whitespace-nowrap"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-yellow-50 text-yellow-700">Pending</span></td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-600">{{ \Carbon\Carbon::parse($inv->created_at)->format('M d, Y') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-right">
                            <a href="{{ route('dashboard.patients.show', $inv->patient_user_id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-sky-600 text-white hover:bg-sky-700">View</a>
                        </td>
                    </tr>
                    @endforeach
                    @foreach($emailInvites as $inv)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-600">—</td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-600">{{ $inv->invite_email }}</td>
                        <td class="px-4 py-2 whitespace-nowrap"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-yellow-50 text-yellow-700">Pending</span></td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-600">{{ \Carbon\Carbon::parse($inv->created_at)->format('M d, Y') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-right">&nbsp;</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection

