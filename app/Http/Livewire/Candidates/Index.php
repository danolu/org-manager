<?php

namespace App\Http\Livewire\Candidates;

use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['candidateUpdated' => '$refresh'];

    public function destroy($id)
    {
        $candidate = Candidate::findOrFail($id);
        if ($candidate->photo) {
            Storage::disk('public')->delete($candidate->photo);
        }
        $candidate->delete();

        session()->flash('success', 'Candidate deleted successfully.');
        $this->emitSelf('candidateUpdated');
    }

    public function render()
    {
        $candidates = Candidate::with('position')
            ->orderBy('position_id')
            ->get();

        return view('livewire.candidates.index', compact('candidates'));
    }
}
