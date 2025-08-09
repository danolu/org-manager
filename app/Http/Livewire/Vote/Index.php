<?php

namespace App\Http\Livewire\Vote;

use App\Models\Position;
use App\Services\ElectionService;
use Livewire\Component;

class Index extends Component
{
    protected ElectionService $electionService;

    public function __construct()
    {
        $this->electionService = app(ElectionService::class);
    }

    public function render()
    {
        $positions = $this->electionService->getAllPositions();
        $user = auth()->user();

        // Filter positions user can vote for
        $positions = $positions->filter(function ($position) use ($user) {
            return $position->canUserVote($user);
        });

        return view('livewire.vote.index', compact('positions'));
    }
}
