<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with('position')
            ->orderBy('position_id')
            ->get();

        return view('candidates.index', compact('candidates'));
    }

    public function create()
    {
        $positions = Position::orderBy('created_at')->get();

        return view('candidates.create', compact('positions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'position_id' => 'required|exists:positions,id',
            'name' => 'required|string|max:255',
            'tag' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        Candidate::create($validated);

        return redirect()->route('candidates.index')->with('success', 'Candidate added successfully.');
    }

    public function show(Candidate $candidate)
    {
        $candidate->load('position');

        return view('candidates.show', compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        $positions = Position::orderBy('created_at')->get();

        return view('candidates.edit', compact('candidate', 'positions'));
    }

    public function update(Request $request, Candidate $candidate): RedirectResponse
    {
        $validated = $request->validate([
            'position_id' => 'required|exists:positions,id',
            'name' => 'required|string|max:255',
            'tag' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($candidate->photo) {
                Storage::disk('public')->delete($candidate->photo);
            }
            $validated['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        $candidate->update($validated);

        return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy(Candidate $candidate): RedirectResponse
    {
        if ($candidate->photo) {
            Storage::disk('public')->delete($candidate->photo);
        }

        $candidate->delete();

        return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully.');
    }
}
