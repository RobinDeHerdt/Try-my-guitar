<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $twitter_user = Socialite::driver('twitter')->user();

        $existing_user = User::where('twitter_id', $twitter_user->id)->first();

        if (!$existing_user) {
            $user = new User();

            $user->first_name           = $twitter_user->name;
            $user->email                = $twitter_user->email;
            $user->twitter_id           = $twitter_user->id;
            $user->verification_token   = str_random(12);

            $user->save();

            $user->roles()->attach(3);

            Mail::to($user->email)->send(new VerifyEmail($user));

            Session::flash('success-message', __('flash.verification-sent', ['email' => $user->email]));

            Auth::login($user);
        } else {
            Auth::login($existing_user);
        }

        return redirect(route('dashboard'));
    }
}
