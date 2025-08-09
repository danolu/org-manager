<?php

namespace App\Http\Livewire\Positions;

use App\Models\Position;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['positionUpdated' => '$refresh'];

    public function mount()
    {
        $user = auth()->user();
        if (! $user || ! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            abort(403);
        }
    }

    public function destroy(Position $position)
    {
        if ($position->candidates()->count() > 0) {
            session()->flash('error', 'Cannot delete position with existing candidates. Please delete candidates first.');
            return;
        }

        $position->delete();
        session()->flash('success', 'Position deleted successfully.');
        $this->emitSelf('positionUpdated');
    }

    public function render()
    {
        $positions = Position::withCount('candidates')->orderBy('created_at')->get();
        return view('livewire.positions.index', compact('positions'));
    }
}
