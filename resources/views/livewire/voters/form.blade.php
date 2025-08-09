<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">{{ $userId ? 'Edit Voter' : 'Add Voter' }}</h2>

    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model.defer="name" class="mt-1 block w-full">
            @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model.defer="email" class="mt-1 block w-full">
            @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" wire:model.defer="phone" class="mt-1 block w-full">
            @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">User ID</label>
            <input type="number" wire:model.defer="user_id" class="mt-1 block w-full">
            @error('user_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="is_admin" class="mr-2">
                <span class="text-sm">Is Admin</span>
            </label>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Password {{ $userId ? '(leave blank to keep current)' : '' }}</label>
            <input type="password" wire:model.defer="password" class="mt-1 block w-full">
            @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary">{{ $userId ? 'Update' : 'Save' }}</button>
            <a href="{{ route('voters.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
