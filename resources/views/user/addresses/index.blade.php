@extends('layouts.user')

@section('main-content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Addresses</h1>
            <p class="text-gray-600 mt-2">Manage your addresses and choose the current one</p>
        </div>
        <a href="{{ route('dashboard.addresses.create') }}" class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700">Add Address</a>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if($addresses->isEmpty())
        <div class="text-gray-600">No addresses yet. Click "Add Address" to create one.</div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($addresses as $address)
                <div class="border rounded-xl p-5 {{ $address->is_current ? 'border-sky-300 bg-sky-50' : 'border-gray-200' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-sm text-gray-500">{{ $address->label ?: 'Address' }}</div>
                            <div class="font-medium text-gray-900 mt-1">{{ $address->full_address }}</div>
                            
                        </div>
                        @if($address->is_current)
                            <span class="px-2 py-1 text-xs bg-sky-100 text-sky-700 rounded">Current</span>
                        @endif
                    </div>
                    <div class="mt-4 flex items-center gap-3">
                        <a href="{{ route('dashboard.addresses.edit', $address->id) }}" class="text-sky-700 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('dashboard.addresses.destroy', $address->id) }}" onsubmit="return confirm('Delete this address?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                        @unless($address->is_current)
                            <form method="POST" action="{{ route('dashboard.addresses.set-current', $address->id) }}" class="ml-auto">
                                @csrf
                                <button type="submit" class="px-3 py-1 text-sm bg-sky-600 text-white rounded hover:bg-sky-700">Set Current</button>
                            </form>
                        @endunless
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

