<?php

namespace App\Http\Livewire\Candidates;

use App\Models\Candidate;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $candidateId;
    public $position_id;
    public $name;
    public $tag;
    public $photo;

    public function mount($candidate = null)
    {
        if ($candidate instanceof Candidate) {
            $this->candidateId = $candidate->id;
            $this->position_id = $candidate->position_id;
            $this->name = $candidate->name;
            $this->tag = $candidate->tag;
        }
    }

    protected function rules()
    {
        return [
            'position_id' => 'required|exists:positions,id',
            'name' => 'required|string|max:255',
            'tag' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->photo) {
            $path = $this->photo->store('candidates', 'public');
            $validated['photo'] = $path;
        }

        if ($this->candidateId) {
            $candidate = Candidate::findOrFail($this->candidateId);
            if (isset($validated['photo']) && $candidate->photo) {
                Storage::disk('public')->delete($candidate->photo);
            }
            $candidate->update($validated);
            session()->flash('success', 'Candidate updated successfully.');
        } else {
            Candidate::create($validated);
            session()->flash('success', 'Candidate added successfully.');
        }

        return redirect()->route('candidates.index');
    }

    public function render()
    {
        $positions = Position::orderBy('created_at')->get();
        return view('livewire.candidates.form', compact('positions'));
    }
}
