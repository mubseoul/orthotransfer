@extends('admin.layouts.app')

@section('page-title', 'Doctors')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Doctors</h2>
        <div class="flex items-center space-x-3">
            <form method="GET" action="{{ route('admin.doctors.index') }}">
                <select name="status" onchange="this.form.submit()" class="text-sm border border-slate-200 rounded-lg px-3 py-2 bg-white text-slate-700">
                    <option value="" {{ $status === null ? 'selected' : '' }}>All</option>
                    <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </form>
            <div class="text-sm text-slate-500">Total: {{ $doctors->total() }}</div>
        </div>
    </div>
    <div class="p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Approved</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Joined</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($doctors as $doctor)
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-800">
                        {{ $doctor->first_name }} {{ $doctor->last_name }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600">{{ $doctor->email }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($doctor->is_approved)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600">{{ $doctor->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-right space-x-2">
                        <a href="{{ route('admin.doctors.show', $doctor) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50">View</a>
                        @if(!$doctor->is_approved)
                            <form method="POST" action="{{ route('admin.doctors.approve', $doctor) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700">Approve</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.doctors.unapprove', $doctor) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200">Unapprove</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">No doctors found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $doctors->links('admin.components.pagination') }}</div>
    </div>
    
</div>
@endsection

