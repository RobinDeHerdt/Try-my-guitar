<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class VerifyController extends Controller
{
    /**
     * Compare the token the user send us with the token stored in the database.
     * If true, give the user the 'verified' status.
     *
     * @param  integer  $id
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function verify($id, $token)
    {
        $user = User::find($id);

        if ($user->verification_token === $token) {
            $user->verified = true;
            $user->save();

            Session::flash('success-message', 'You are now verified!');

            if (!Auth::check()) {
                Auth::login($user);
            }
        } else {
            Session::flash('error-message', 'Verification invalid. Please request another email from the dashboard.');
        }

        return redirect(route('dashboard'));
    }

    /**
     * Sends the verification mail once again.
     *
     * @return \Illuminate\Http\Response
     */
    public function resend()
    {
        $user = Auth::user();

        Mail::to($user->email)->send(new VerifyEmail($user));

        Session::flash('success-message', "We've sent you a verification at " . $user->email . '.');

        return redirect(route('dashboard'));
    }
}