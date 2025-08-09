@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Candidates</h1>
    </div>

    <a href="{{ route('candidates.create') }}" class="btn-primary mb-6 inline-block">Add New</a>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($candidates as $candidate)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($candidate->type) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $candidate->level ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $candidate->title ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $candidate->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('candidates.edit', $candidate) }}" class="btn-warning inline-block text-xs py-1 px-3">Edit</a>
                        <form action="{{ route('candidates.destroy', $candidate) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button class="btn-danger text-xs py-1 px-3" onclick="return confirm('Delete this candidate?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No candidates found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection