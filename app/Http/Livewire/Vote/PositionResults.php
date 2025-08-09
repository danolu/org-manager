<?php

namespace App\Http\Livewire\Vote;

use App\Models\Position as PositionModel;
use App\Services\ElectionService;
use Illuminate\Support\Str;
use Livewire\Component;

class PositionResults extends Component
{
    protected ElectionService $electionService;
    public $positionSlug;

    public function __construct()
    {
        $this->electionService = app(ElectionService::class);
    }

    public function mount($position)
    {
        $user = auth()->user();
        if (! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        if ($position instanceof PositionModel) {
            $this->positionSlug = Str::slug($position->name, '-');
        } else {
            $this->positionSlug = $position;
        }
    }

    public function render()
    {
        $position = $this->electionService->getPositionBySlug($this->positionSlug);

        if (! $position) {
            return view('livewire.vote.position-results-not-found');
        }

        $results = $this->electionService->getResultsForPosition($position);

        return view('livewire.vote.position-results', compact('position', 'results'));
    }
}
