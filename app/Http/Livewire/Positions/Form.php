<?php

namespace App\Http\Livewire\Positions;

use App\Models\Position;
use Livewire\Component;

class Form extends Component
{
    public $positionId;
    public $name;
    public $type = 'single';
    public $max_vote;
    public $category;

    public function mount($position = null)
    {
        $user = auth()->user();
        if (! $user || ! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            abort(403);
        }

        if ($position instanceof Position) {
            $this->positionId = $position->id;
            $this->name = $position->name;
            $this->type = $position->type;
            $this->max_vote = $position->max_vote;
            $this->category = $position->category;
        }
    }

    protected function rules()
    {
        $unique = $this->positionId ? ','.$this->positionId : '';
        return [
            'name' => 'required|string|max:255|unique:positions,name'.$unique,
            'type' => 'required|in:single,multiple,yes-no',
            'max_vote' => 'nullable|integer|min:1|max:10',
            'category' => 'nullable|string|max:50',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($validated['type'] === 'multiple' && empty($validated['max_vote'])) {
            $validated['max_vote'] = 2;
        }

        if ($this->positionId) {
            $position = Position::findOrFail($this->positionId);
            $position->update($validated);
            session()->flash('success', 'Position updated successfully.');
            return redirect()->route('positions.index');
        }

        Position::create($validated);
        session()->flash('success', 'Position created successfully.');
        return redirect()->route('positions.index');
    }

    public function render()
    {
        return view('livewire.positions.form');
    }
}
