<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use App\User;
use Auth;

class ProfileController extends Controller
{
    /**
     * Contains the authenticated user.
     *
     * @var array
     */
    private $user;

    /**
     * Constructor.
     *
     * Check if the user has the 'user' role.
     * Get the authenticated user and save it to the $user variable.
     */
    public function __construct()
    {
        $this->middleware('role:user')->except('show');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show the specified user profile.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('profile.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the edit form for the specified user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => $this->user,
        ]);
    }

    /**
     * Update the specified user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $send_mail  = false;
        $user       = $this->user;

        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;

        if ($request->email !== $user->email) {
            $user->email                = $request->email;
            $user->verified             = false;
            $user->verification_token   = str_random(12);
            $send_mail                  = true;
        }

        $user->location     = $request->location;

        if (isset($request->image)) {
            $user->image_uri = $request->image->store('images', 'public');
        }

        $user->save();

        if ($send_mail) {
            Mail::to($user->email)->send(new VerifyEmail($user));
            Session::flash('success-message', 'Personal information updated successfully. We\'ve sent a verification link to your new email address.');
        } else {
            Session::flash('success-message', 'Personal information updated successfully.');
        }

        return back();
    }

    /**
     * Update the specified user profile appearance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAppearance(Request $request)
    {
        $user = $this->user;

        $user->description      = $request->description;

        if (isset($request->image)) {
            $user->header_image_uri = $request->image->store('images', 'public');
        }

        $user->save();

        Session::flash('success-message', 'Profile appearance updated successfully.');

        return back();
    }

    /**
     * Show the specified user invite page.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function invite(User $user)
    {
        $channels = $this->user->channels()->where('accepted', true)->get();

        return view('profile.invite', [
            'user'      => $user,
            'channels'  => $channels,
        ]);
    }
}
