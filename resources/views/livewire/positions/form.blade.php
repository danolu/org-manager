<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">{{ $positionId ? 'Edit Position' : 'Add Position' }}</h2>

    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model.defer="name" class="mt-1 block w-full">
            @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Type</label>
            <select wire:model="type" class="mt-1 block w-full">
                <option value="single">Single choice</option>
                <option value="multiple">Multiple choice</option>
                <option value="yes-no">Yes/No</option>
            </select>
            @error('type') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Max votes (for multiple)</label>
            <input type="number" wire:model.defer="max_vote" min="1" max="10" class="mt-1 block w-full">
            @error('max_vote') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Category (optional)</label>
            <input type="text" wire:model.defer="category" class="mt-1 block w-full">
            @error('category') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary">{{ $positionId ? 'Update' : 'Save' }}</button>
            <a href="{{ route('positions.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
