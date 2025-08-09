<?php

namespace App\Http\Livewire\Vote;

use App\Models\Position as PositionModel;
use App\Services\ElectionService;
use Livewire\Component;

class Results extends Component
{
    protected ElectionService $electionService;

    public function __construct()
    {
        $this->electionService = app(ElectionService::class);
    }

    public function render()
    {
        $user = auth()->user();

        if (! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $results = $this->electionService->getResults();

        return view('livewire.vote.results', compact('results'));
    }
}
