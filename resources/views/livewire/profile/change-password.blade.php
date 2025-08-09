<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Change Password</h2>

    @if(session('success'))
        <div class="alert-success mb-4">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Current Password</label>
            <input type="password" wire:model.defer="current_password" class="mt-1 block w-full">
            @error('current_password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="password" wire:model.defer="password" class="mt-1 block w-full">
            @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <input type="password" wire:model.defer="password_confirmation" class="mt-1 block w-full">
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary">Change Password</button>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
