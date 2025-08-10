@extends('admin.layouts.app')

@section('page-title', 'Patients')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Patients</h2>
        <div class="text-sm text-slate-500">Total: {{ $patients->total() }}</div>
    </div>
    <div class="p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Joined</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($patients as $patient)
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-800">
                        {{ $patient->first_name }} {{ $patient->last_name }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600">{{ $patient->email }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600">{{ $patient->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-right">
                        <a href="{{ route('admin.patients.show', $patient) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">No patients found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $patients->links('admin.components.pagination') }}</div>
    </div>
    
</div>
@endsection

