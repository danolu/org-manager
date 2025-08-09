<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Candidates</h1>
        <a href="{{ route('candidates.create') }}" class="btn-primary">Add New</a>
    </div>

    @if(session('success'))
        <div class="alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($candidates as $candidate)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $candidate->position?->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $candidate->tag ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $candidate->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('candidates.edit', $candidate) }}" class="btn-warning inline-block text-xs py-1 px-3">Edit</a>
                        <button wire:click="destroy({{ $candidate->id }})" class="btn-danger text-xs py-1 px-3" onclick="return confirm('Delete this candidate?')">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No candidates found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
