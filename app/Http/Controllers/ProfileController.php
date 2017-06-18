<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\VerifyEmail;
use App\User;
use Auth;

/**
 * Class ProfileController
 * @package App\Http\Controllers
 */
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
        $ip_address     = request()->ip();
        $user_location  = geoip($ip_address);
        $user_coords    = [
            'lat' => $user_location->lat,
            'lng' => $user_location->lon
        ];

        return view('profile.edit', [
            'user'          => $this->user,
            'user_coords'   => json_encode($user_coords),
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
        $user->location_lat = $request->location_lat;
        $user->location_lng = $request->location_lng;

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
     * Show the specified user profile.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function experiences(User $user)
    {
        $experiences = $user->experiences()->get();

        return view('profile.experiences', [
            'experiences'   => $experiences,
            'user'          => $user,
        ]);
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
