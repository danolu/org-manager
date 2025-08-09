<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vote;
use App\Services\ElectionService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    protected ElectionService $electionService;

    public function __construct(ElectionService $electionService)
    {
        $this->electionService = $electionService;
    }

    public function voters()
    {
        $data['voters'] = User::where('isAlum', false)->get();

        return view('voters', $data);
    }

    public function members()
    {
        $data['voters'] = User::where('isAlum', false)->get();
        if (Auth()->user()->isAdmin() === true) {
            return view('members', $data);
        } else {
            return back()->with('alert', 'You do not have access to this page');
        }
    }

    public function notStarted()
    {
        return redirect('/')->with('message', 'Voting has not yet started.');
    }

    public function hasEnded()
    {
        return redirect('/')->with('message', 'Voting has ended.');
    }

    public function index()
    {
        $users = User::whereHas('votes')
            ->with('votes')
            ->get();

        $categories = $users->unique('category')->pluck('category')->toArray();

        foreach ($users as $user) {
            $category = (string) $user->category;
            if (array_key_exists($category, $voters)) {
                $categories[$category][] = $user;
            }
        }

        return view('election', ['voters' => $voters]);
    }

    /**
     * Vote for a position (dynamic, database-driven)
     */
    public function vote(Request $request, string $slug)
    {
        $position = $this->electionService->getPositionBySlug($slug);

        if (! $position) {
            return redirect('/election')->with('error', 'Position not found.');
        }

        $user = Auth::user();

        // Check if user can vote for this position based on category
        if (! $position->canUserVote($user)) {
            $categoryMsg = $position->category ? " (restricted to {$position->category} category)" : '';

            return redirect('/election')->with('error', "You are not eligible to vote for {$position->name}{$categoryMsg}.");
        }

        if ($this->electionService->hasUserVoted($user, $position)) {
            return redirect('/election')->with('success', "You have already voted for {$position->name}.");
        }

        if ($request->isMethod('post')) {
            $result = $this->electionService->castVote($user, $position, $request);

            if (isset($result['error'])) {
                return back()->with('error', $result['error'])->withInput();
            }

            // Get next position that user can vote for
            $nextPosition = $this->electionService->getNextPosition($position);

            // Skip positions user cannot vote for
            while ($nextPosition && ! $nextPosition->canUserVote($user)) {
                $nextPosition = $this->electionService->getNextPosition($nextPosition);
            }

            if ($nextPosition) {
                return redirect("/vote/{$nextPosition->slug}")->with('success', "Voted successfully for {$position->name}.");
            } else {
                return redirect('/election')->with('success', "Voted successfully for {$position->name}. You have completed voting!");
            }
        }

        return view('vote.position', [
            'position' => $position,
            'candidates' => $position->candidates,
            'inputName' => Str::slug($position->name, '-'),
        ]);
    }

    public function results()
    {
        $user = Auth::user();

        if (! $user->Admin()) {
            return redirect('/election')->with('error', 'You are not authorized to view this page');
        }

        $results = $this->electionService->getResults();

        return view('results', ['results' => $results]);
    }

    public function positionResults(string $slug)
    {
        $user = Auth::user();

        if (! $user->isAdmin()) {
            return redirect('/election')->with('error', 'You are not authorized to view this page');
        }

        $position = $this->electionService->getPositionBySlug($slug);

        if (! $position) {
            return redirect()->route('results')->with('error', 'Position not found.');
        }

        $results = $this->electionService->getResultsForPosition($position);

        return view('results.position', [
            'position' => $position,
            'results' => $results,
        ]);
    }
}
