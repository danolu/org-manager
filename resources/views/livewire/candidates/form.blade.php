<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">{{ $candidateId ? 'Edit Candidate' : 'Add Candidate' }}</h2>

    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Position</label>
            <select wire:model="position_id" class="mt-1 block w-full">
                <option value="">Select position</option>
                @foreach($positions as $pos)
                    <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                @endforeach
            </select>
            @error('position_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tag</label>
            <input type="text" wire:model.defer="tag" class="mt-1 block w-full" placeholder="Optional tag">
            @error('tag') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model.defer="name" class="mt-1 block w-full" required>
            @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Photo</label>
            <input type="file" wire:model="photo" class="mt-1 block w-full">
            @error('photo') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary">{{ $candidateId ? 'Update' : 'Save' }}</button>
            <a href="{{ route('candidates.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
