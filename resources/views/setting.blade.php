@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Site Settings</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('settings.update', $setting->id ?? 1) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Session --}}
        <div>
            <label for="session" class="block font-medium mb-1">Current Session</label>
            <input 
                type="text" 
                name="session" 
                id="session" 
                value="{{ old('session', $setting->session ?? '') }}" 
                class="border border-gray-300 rounded px-3 py-2 w-full"
                placeholder="e.g. 2024/2025"
                required
            >
            @error('session')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Due Amount --}}
        <div>
            <label for="due_amount" class="block font-medium mb-1">Due Amount (₦)</label>
            <input 
                type="number" 
                step="0.01" 
                name="due_amount" 
                id="due_amount" 
                value="{{ old('due_amount', $setting->due_amount ?? '') }}" 
                class="border border-gray-300 rounded px-3 py-2 w-full"
                placeholder="e.g. 5000"
                required
            >
            @error('due_amount')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Election Time --}}
        <div class="flex items-center">
            <input 
                type="checkbox" 
                name="is_election_time" 
                id="is_election_time" 
                value="1" 
                {{ old('is_election_time', $setting->is_election_time ?? false) ? 'checked' : '' }}
                class="mr-2"
            >
            <label for="is_election_time" class="font-medium">Is Election Time?</label>
        </div>

        {{-- Submit --}}
        <div>
            <button 
                type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection