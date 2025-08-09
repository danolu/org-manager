<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     *
     * @return Response
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_id';

        $user_check = User::where($loginField, $request->login)->first();

        if (! $user_check) {
            return back()->withErrors([
                'login' => 'User not recognised.',
            ])->onlyInput('login');
        }

        $remember = $request->has('remember') ? true : false;

        if ($user_check && Auth::attempt([$loginField => $request->login, 'password' => $request->password], $remember)) {
            $user = Auth::user();
            if (Hash::check('password', $user->password)) {
                $request->session()->regenerate();

                return redirect('/change-password')->with('message', 'Please change your password to continue');
            } else {
                $request->session()->regenerate();

                return redirect()->intended('/');
            }
        } elseif (! $user_check) {
            return back()->withErrors([
                'login' => 'User not recognised.',
            ])->onlyInput('login');
        } else {
            return back()->withErrors([
                'password' => 'You entered an incorrect password.',
            ])->onlyInput('login');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
