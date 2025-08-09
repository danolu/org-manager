<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        $voters = User::orderBy('created_at', 'desc')->paginate(20);

        return view('voters.index', compact('voters'));
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        return view('voters.create');
    }

    /**
     * Store a newly created user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to perform this action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'user_id' => 'required|integer|unique:users,user_id',
            'category_id' => 'nullable|integer',
            'phone' => 'nullable|numeric|unique:users,phone',
            'password' => 'required|string|min:6',
            'is_admin' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = $request->has('is_admin') ? true : false;

        User::create($validated);

        return redirect()->route('voters.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        if (! $request->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        return view('voters.show', compact('user'));
    }

    /**
     * Show the form for editing the user's own profile
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('voters.edit');
    }

    /**
     * Show the form for editing a specific user
     *
     * @return \Illuminate\Http\Response
     */
    public function editUser(Request $request, User $user)
    {
        if (! $request->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        return view('voters.edit-user', compact('user'));
    }

    /**
     * Update the authenticated user's own profile
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric',
        ]);

        $user = $request->user();
        $user->phone = $request->phone;
        $sav = $user->save();
        if ($sav) {
            return back()->with('success', 'Profile updated');
        } else {
            return back()->with('alert', 'Error updating profile');
        }
    }

    /**
     * Update a specific user
     *
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, User $user)
    {
        if (! $request->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to perform this action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'user_id' => 'required|integer|unique:users,user_id,'.$user->id,
            'category_id' => 'nullable|integer',
            'phone' => 'nullable|numeric|unique:users,phone,'.$user->id,
            'is_admin' => 'nullable|boolean',
        ]);

        $validated['is_admin'] = $request->has('is_admin') ? true : false;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('voters.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if (! $request->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to perform this action.');
        }

        if ($user->id === $request->user()->id) {
            return redirect()->route('voters.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('voters.index')
            ->with('success', 'User deleted successfully.');
    }

    public function password()
    {
        return view('change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|string|min:6',
        ]);
        if (! Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors(['current_password' => ['The provided password does not match our records.']]);
        }
        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Your password has been changed successfully.');
    }
}
