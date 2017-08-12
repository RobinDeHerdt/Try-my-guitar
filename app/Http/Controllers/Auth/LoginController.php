<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\URL;
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
     * Show the application's login form.
     * Store the user's intended url so we can redirect back after login.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (Url::previous()) {
            session(['intended_url' => Url::previous()]);
        }

        return view('auth.login');
    }

    /**
     * The user has been authenticated.
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated()
    {
        if (session('intended_url')) {
            return redirect(session('intended_url'));
        }

        return redirect(route('dashboard'));
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Socialite
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return Socialite
     */
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $google_user = Socialite::driver('google')->user();

        $existing_user = User::where('google_id', $google_user->id)->first();

        if (!$existing_user) {
            if (User::where('email', $google_user->email)->exists()) {
                Session::flash('info-message', __('flash.email-exists'));
                return redirect(route('login'));
            }

            $user = new User();

            $user->first_name           = $google_user->name;
            $user->email                = $google_user->email;
            $user->google_id            = $google_user->id;
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

    /**
     * Obtain the user information from Twitter.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleTwitterCallback()
    {
        $twitter_user = Socialite::driver('twitter')->user();

        $existing_user = User::where('twitter_id', $twitter_user->id)->first();

        if (!$existing_user) {
            if (User::where('email', $twitter_user->email)->exists()) {
                Session::flash('info-message', __('flash.email-exists'));
                return redirect(route('login'));
            }

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
