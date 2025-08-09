<?php

namespace App\Http\Livewire\Vote;

use App\Models\Position as PositionModel;
use App\Services\ElectionService;
use Illuminate\Support\Str;
use Livewire\Component;

class Position extends Component
{
    protected ElectionService $electionService;
    public $positionSlug;
    public $selectedCandidates = [];

    public function __construct()
    {
        $this->electionService = app(ElectionService::class);
    }

    public function mount($position)
    {
        if ($position instanceof PositionModel) {
            $this->positionSlug = Str::slug($position->name, '-');
        } else {
            $this->positionSlug = $position;
        }
    }

    public function submit()
    {
        $position = $this->electionService->getPositionBySlug($this->positionSlug);
        if (! $position) {
            session()->flash('error', 'Position not found.');
            return redirect()->route('vote');
        }

        $user = auth()->user();

        if (! $position->canUserVote($user)) {
            session()->flash('error', "You are not eligible to vote for {$position->name}.");
            return redirect()->route('vote');
        }

        if ($this->electionService->hasUserVoted($user, $position)) {
            session()->flash('success', "You have already voted for {$position->name}.");
            return redirect()->route('vote');
        }

        // Build request from Livewire data
        $inputName = Str::slug($position->name, '-');
        $request = new \Illuminate\Http\Request();
        $request->merge([
            $inputName => $this->selectedCandidates['single'] ?? null,
            'candidates' => $this->selectedCandidates['multiple'] ?? [],
            'vote_' . implode('_', array_keys($this->selectedCandidates['yesno'] ?? [])) => array_values($this->selectedCandidates['yesno'] ?? []),
        ]);

        $result = $this->electionService->castVote($user, $position, $request);

        if (isset($result['error'])) {
            session()->flash('error', $result['error']);
            return;
        }

        $nextPosition = $this->electionService->getNextPosition($position);
        while ($nextPosition && ! $nextPosition->canUserVote($user)) {
            $nextPosition = $this->electionService->getNextPosition($nextPosition);
        }

        if ($nextPosition) {
            return redirect('/vote/' . Str::slug($nextPosition->name, '-'))->with('success', "Voted successfully for {$position->name}.");
        } else {
            return redirect()->route('vote')->with('success', "Voted successfully for {$position->name}. You have completed voting!");
        }
    }

    public function render()
    {
        $position = $this->electionService->getPositionBySlug($this->positionSlug);
        if (! $position) {
            return view('livewire.vote.not-found');
        }

        $user = auth()->user();
        if (! $position->canUserVote($user)) {
            return view('livewire.vote.not-eligible', compact('position'));
        }

        if ($this->electionService->hasUserVoted($user, $position)) {
            return view('livewire.vote.already-voted', compact('position'));
        }

        return view('livewire.vote.position', [
            'position' => $position,
            'candidates' => $position->candidates,
        ]);
    }
}
