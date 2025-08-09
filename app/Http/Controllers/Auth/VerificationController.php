<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    public function index()
    {
        $data['title'] = 'Verify Email';

        return view('auth.verify-email', $data);
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('dashboard')->with('success', 'Email verified sucessfully');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
