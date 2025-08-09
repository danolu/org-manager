<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ElectionService
{
    /**
     * Get all positions ordered by creation
     */
    public function getAllPositions()
    {
        return Position::with('candidates')->orderBy('created_at')->get();
    }

    /**
     * Get a position by its slug
     */
    public function getPositionBySlug(string $slug): ?Position
    {
        return Position::with('candidates')
            ->get()
            ->first(function ($position) use ($slug) {
                return Str::slug($position->name, '-') === $slug;
            });
    }

    /**
     * Get a position by its ID
     */
    public function getPositionById(int $id): ?Position
    {
        return Position::with('candidates')->find($id);
    }

    /**
     * Check if user has voted for a specific position
     */
    public function hasUserVoted(User $user, Position $position): bool
    {
        return Vote::where('user_id', $user->id)
            ->where('position_id', $position->id)
            ->exists();
    }

    /**
     * Cast vote(s) for a position
     */
    public function castVote(User $user, Position $position, Request $request): array
    {
        $inputName = Str::slug($position->name, '-');
        $candidates = $position->candidates;

        if ($candidates->isEmpty()) {
            return ['error' => "No candidates available for {$position->name}."];
        }

        // Check if user can vote for this position based on category
        if (! $position->canUserVote($user)) {
            return ['error' => "You are not eligible to vote for {$position->name}. This position is restricted to {$position->category} category."];
        }

        // Handle different position types
        if ($position->isYesNo()) {
            // Yes/No vote - User must vote yes or no for ALL candidates
            $validationRules = [];
            foreach ($candidates as $candidate) {
                $validationRules["vote_{$candidate->id}"] = 'required|in:yes,no';
            }

            $request->validate($validationRules);

            // Store vote for each candidate
            foreach ($candidates as $candidate) {
                $vote = $request->input("vote_{$candidate->id}");
                $this->storeVote($user, $position, $candidate, $vote);
            }

        } elseif ($position->isSingle()) {
            // Select one candidate from all candidates
            $request->validate([
                $inputName => 'required|exists:candidates,id',
            ]);

            $candidateId = $request->input($inputName);
            $candidate = $candidates->firstWhere('id', $candidateId);

            if (! $candidate) {
                return ['error' => 'Invalid candidate selected.'];
            }

            $this->storeVote($user, $position, $candidate, 'yes');

        } elseif ($position->isMultiple()) {
            // Select multiple candidates (up to max_vote)
            $maxVotes = $position->max_vote ?? 2;

            $request->validate([
                'candidates' => 'required|array|min:1|max:'.$maxVotes,
                'candidates.*' => 'exists:candidates,id',
            ]);

            $selectedIds = $request->input('candidates', []);

            foreach ($selectedIds as $candidateId) {
                $candidate = $candidates->firstWhere('id', $candidateId);

                if (! $candidate) {
                    return ['error' => 'Invalid candidate selected.'];
                }

                $this->storeVote($user, $position, $candidate, 'yes');
            }
        }

        return ['success' => true];
    }

    /**
     * Get the next position after the current one
     */
    public function getNextPosition(Position $position): ?Position
    {
        return Position::where('id', '>', $position->id)
            ->orderBy('id')
            ->first();
    }

    /**
     * Get election results for all positions
     */
    public function getResults(): array
    {
        $positions = Position::with(['candidates', 'votes'])->get();
        $results = [];

        foreach ($positions as $position) {
            $positionResults = [];

            foreach ($position->candidates as $candidate) {
                $voteCount = Vote::where('position_id', $position->id)
                    ->where('candidate_id', $candidate->id)
                    ->where('vote', 'yes')
                    ->count();

                $positionResults[] = [
                    'candidate' => $candidate,
                    'votes' => $voteCount,
                ];
            }

            // Sort by votes descending
            usort($positionResults, function ($a, $b) {
                return $b['votes'] <=> $a['votes'];
            });

            $results[] = [
                'position' => $position,
                'results' => $positionResults,
            ];
        }

        return $results;
    }

    /**
     * Get results for a specific position
     */
    public function getResultsForPosition(Position $position): array
    {
        $results = [];

        foreach ($position->candidates as $candidate) {
            $yesVotes = Vote::where('position_id', $position->id)
                ->where('candidate_id', $candidate->id)
                ->where('vote', 'yes')
                ->count();

            $noVotes = Vote::where('position_id', $position->id)
                ->where('candidate_id', $candidate->id)
                ->where('vote', 'no')
                ->count();

            $results[] = [
                'candidate' => $candidate,
                'yes_votes' => $yesVotes,
                'no_votes' => $noVotes,
                'total_votes' => $yesVotes + $noVotes,
            ];
        }

        // Sort by yes votes descending
        usort($results, function ($a, $b) {
            return $b['yes_votes'] <=> $a['yes_votes'];
        });

        return $results;
    }

    /* -------------------------- PRIVATE HELPERS -------------------------- */

    /**
     * Store a vote in the database
     */
    private function storeVote(User $user, Position $position, Candidate $candidate, string $vote): void
    {
        Vote::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'candidate_id' => $candidate->id,
            'vote' => $vote,
        ]);
    }
}
