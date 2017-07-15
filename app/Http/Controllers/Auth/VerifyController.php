<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Traits\Exp;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class VerifyController extends Controller
{
    use Exp;

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

        if ($user->verified === true) {
            Session::flash('info-message', __('flash.already-verified'));
        } else {
            if ($user->verification_token === $token) {
                $user->verified = true;
                $user->save();

                $this->addExp($user, 100);

                Session::flash('success-message', __('flash.verified'));

                if (!Auth::check()) {
                    Auth::login($user);
                }
            } else {
                Session::flash('error-message', __('flash.verification-failed'));
            }
        }

        return redirect(route('dashboard'));
    }

    /**
     * Send the verification mail again.
     *
     * @return \Illuminate\Http\Response
     */
    public function resend()
    {
        $user = Auth::user();

        Mail::to($user->email)->send(new VerifyEmail($user));

        Session::flash('success-message', __('flash.verification-sent', ['email' => $user->email]));

        return redirect(route('dashboard'));
    }
}
