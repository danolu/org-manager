<?php

namespace App\Http\Livewire\Voters;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public $userId;

    public function mount(User $user)
    {
        $auth = auth()->user();
        if (! $auth || ! method_exists($auth, 'isAdmin') || ! $auth->isAdmin()) {
            abort(403);
        }

        $this->userId = $user->id;
    }

    public function render()
    {
        $user = User::findOrFail($this->userId);
        return view('livewire.voters.show', compact('user'));
    }
}
