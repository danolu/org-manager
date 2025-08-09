<?php

namespace App\Http\Livewire\Voters;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['userUpdated' => '$refresh'];

    public $perPage = 20;

    public function mount()
    {
        $user = auth()->user();
        if (! $user || ! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            abort(403);
        }
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully.');
        $this->emitSelf('userUpdated');
    }

    public function render()
    {
        $voters = User::orderBy('created_at', 'desc')->paginate($this->perPage);
        return view('livewire.voters.index', compact('voters'));
    }
}
