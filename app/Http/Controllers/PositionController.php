<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (! $user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        $positions = Position::withCount('candidates')->orderBy('created_at')->get();

        return view('positions.index', compact('positions'));
    }

    public function create(Request $request)
    {
        $user = $request->user();

        if (! $user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        return view('positions.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (! $user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to perform this action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name',
            'type' => 'required|in:single,multiple,yes-no',
            'max_vote' => 'nullable|integer|min:1|max:10',
            'category' => 'nullable|string|max:50',
        ]);

        if ($validated['type'] === 'multiple' && empty($validated['max_vote'])) {
            $validated['max_vote'] = 2;
        }

        Position::create($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position created successfully.');
    }

    public function show(Request $request, Position $position)
    {
        $user = $request->user();

        if (! $user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        $position->load('candidates');

        return view('positions.show', compact('position'));
    }

    public function edit(Request $request, Position $position)
    {
        $user = $request->user();

        if (! $user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $user = $request->user();

        if (! $user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to perform this action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name,'.$position->id,
            'type' => 'required|in:single,multiple,yes-no',
            'max_vote' => 'nullable|integer|min:1|max:10',
            'category' => 'nullable|string|max:50',
        ]);

        if ($validated['type'] === 'multiple' && empty($validated['max_vote'])) {
            $validated['max_vote'] = 2;
        }

        $position->update($validated);

        return redirect()->route('positions.show', $position)
            ->with('success', 'Position updated successfully.');
    }

    public function destroy(Request $request, Position $position)
    {
        $user = $request->user();

        if (! $user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to perform this action.');
        }

        if ($position->candidates()->count() > 0) {
            return redirect()->route('positions.index')
                ->with('error', 'Cannot delete position with existing candidates. Please delete candidates first.');
        }

        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Position deleted successfully.');
    }
}
