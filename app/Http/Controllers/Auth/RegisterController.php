<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'user_id' => 'required|string|unique:users|max:45',
            'category' => 'required|string|max:45',
            'phone' => 'nullable|string|max:20',
            'email' => 'bail|required|email|max:191|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->user_id = $request->user_id;
        $user->category = $request->category;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->is_admin = false;
        $user->password = Hash::make($request->password);
        $user->save();
        event(new Registered($user));

        return route('login');
    }
}
