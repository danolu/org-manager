<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Site Settings</h1>

    @if(session('success'))
        <div class="alert-success mb-4">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Site Name</label>
                <input type="text" wire:model.defer="name" class="mt-1 block w-full">
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tenure</label>
                <input type="text" wire:model.defer="tenure" class="mt-1 block w-full">
                @error('tenure') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
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
                <label class="block text-sm font-medium text-gray-700">Website</label>
                <input type="text" wire:model.defer="website" class="mt-1 block w-full">
                @error('website') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" wire:model.defer="address" class="mt-1 block w-full">
                @error('address') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tagline</label>
                <input type="text" wire:model.defer="tagline" class="mt-1 block w-full">
                @error('tagline') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ID Name</label>
                <input type="text" wire:model.defer="id_name" class="mt-1 block w-full">
                @error('id_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea wire:model.defer="description" rows="4" class="mt-1 block w-full"></textarea>
            @error('description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Logo</label>
                <input type="file" wire:model="logo" class="mt-1 block w-full">
                @error('logo') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Favicon</label>
                <input type="file" wire:model="favicon" class="mt-1 block w-full">
                @error('favicon') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Election Start</label>
                <input type="datetime-local" wire:model.defer="election_start" class="mt-1 block w-full">
                @error('election_start') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Election End</label>
                <input type="datetime-local" wire:model.defer="election_end" class="mt-1 block w-full">
                @error('election_end') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Due Deadline</label>
                <input type="date" wire:model.defer="due_deadline" class="mt-1 block w-full">
                @error('due_deadline') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Due Amount</label>
                <input type="number" wire:model.defer="due_amount" step="0.01" class="mt-1 block w-full">
                @error('due_amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="space-y-2 mb-4">
            <label class="flex items-center">
                <input type="checkbox" wire:model="is_election_time" class="mr-2">
                <span class="text-sm">Is Election Time</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" wire:model="is_registration_open" class="mr-2">
                <span class="text-sm">Is Registration Open</span>
            </label>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary">Save Settings</button>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
