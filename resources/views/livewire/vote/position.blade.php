<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4">{{ $position->name }}</h2>

    @if(session('error'))
        <div class="alert-error mb-4">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="submit">
        @if($position->isSingle())
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select one candidate</label>
                <div class="space-y-2">
                    @foreach($candidates as $candidate)
                        <label class="flex items-center">
                            <input type="radio" name="{{ \Illuminate\Support\Str::slug($position->name, '-') }}" value="{{ $candidate->id }}" wire:model="selectedCandidates.single" class="mr-2">
                            <span>{{ $candidate->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

        @elseif($position->isMultiple())
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select up to {{ $position->max_vote }} candidates</label>
                <div class="space-y-2">
                    @foreach($candidates as $candidate)
                        <label class="flex items-center">
                            <input type="checkbox" value="{{ $candidate->id }}" wire:model="selectedCandidates.multiple" class="mr-2">
                            <span>{{ $candidate->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

        @elseif($position->isYesNo())
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-4">Vote Yes/No for each candidate</label>
                @foreach($candidates as $candidate)
                    <div class="mb-4 p-4 border border-gray-200 rounded">
                        <label class="block text-sm font-medium mb-2">{{ $candidate->name }}</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="vote_{{ $candidate->id }}" value="yes" wire:model="selectedCandidates.yesno.{{ $candidate->id }}" class="mr-2">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="vote_{{ $candidate->id }}" value="no" wire:model="selectedCandidates.yesno.{{ $candidate->id }}" class="mr-2">
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary">Submit Vote</button>
            <a href="/vote" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
