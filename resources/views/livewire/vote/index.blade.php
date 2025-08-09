<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Voting</h1>

    @if(session('success'))
        <div class="alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error mb-4">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($positions as $position)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-2">{{ $position->name }}</h2>
                <p class="text-sm text-gray-600 mb-4">Type: <strong>{{ $position->type }}</strong></p>
                <p class="text-sm text-gray-600 mb-4">Candidates: <strong>{{ $position->candidates->count() }}</strong></p>
                <a href="/vote/{{ \Illuminate\Support\Str::slug($position->name, '-') }}" class="btn-primary">Vote</a>
            </div>
        @empty
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">No positions available for voting.</p>
            </div>
        @endforelse
    </div>
</div>
