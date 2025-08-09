<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Voters</h1>
        <a href="{{ route('voters.create') }}" class="btn-primary">Add Voter</a>
    </div>

    @if(session('success'))
        <div class="alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($voters as $voter)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $voter->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $voter->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $voter->phone ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('voters.show', $voter) }}" class="btn-secondary inline-block text-xs py-1 px-3">View</a>
                        <a href="{{ route('voters.edit', $voter) }}" class="btn-warning inline-block text-xs py-1 px-3">Edit</a>
                        <button wire:click="destroy({{ $voter->id }})" class="btn-danger text-xs py-1 px-3" onclick="return confirm('Delete this user?')">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $voters->links() }}
    </div>
</div>
