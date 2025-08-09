<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Edit Profile</h2>

    @if(session('success'))
        <div class="alert-success mb-4">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" wire:model.defer="phone" class="mt-1 block w-full">
            @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary">Save</button>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
