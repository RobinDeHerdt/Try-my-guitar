<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\VerifyEmail;
use App\Traits\Exp;
use App\User;
use Auth;

/**
 * Class ProfileController
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    use Exp;

    /**
     * Contains the authenticated user.
     *
     * @var \App\User
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
        $this->middleware('role:user')->except('show', 'experiences');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show the specified user's profile.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $guitars = $user->guitars()->take(3)->get();
        
        $level = $this->calculateLevel($user->exp);

        return view('profile.show', [
            'user'      => $user,
            'level'     => $level,
            'guitars'   => $guitars,
        ]);
    }

    /**
     * Show the 'edit profile' form for the authenticated user.
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
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'max:255',
            'email' => 'required|string|email|max:255',
            'image' => 'file|image|mimes:jpeg,png,gif|max:1000',
            'location' => 'max:1024',
        ]);

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

        // If the user didn't have a location set initially, award exp for setting it.
        if (!$user->location && !$user->location_lat && !$user->location_lng) {
            if ($request->location && $request->location_lat && $request->location_lng) {
                $this->addExp($user, 100);
            }
        }

        // If the user did have a location set initially, subtract exp for removing it.
        if ($user->location && $user->location_lat && $user->location_lng) {
            if (!$request->location && !$request->location_lat && !$request->location_lng) {
                $this->subtractExp($user, 100);
            }
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
            Session::flash('success-message', __('flash.new-email'));
        } else {
            Session::flash('success-message', __('flash.personal-info-updated'));
        }

        return back();
    }

    /**
     * Show the specified user's experiences.
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
     * Update the specified user's profile appearance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAppearance(Request $request)
    {
        $this->validate($request, [
            'description' => 'max:1024',
            'image' => 'file|image|mimes:jpeg,png,gif|max:1500',
        ]);

        $user = $this->user;

        $user->description = $request->description;

        if (isset($request->image)) {
            $user->header_image_uri = $request->image->store('images', 'public');
        }

        $user->save();

        Session::flash('success-message', __('flash.profile-appearace-updated'));

        return back();
    }

    /**
     * Show the specified user's invite page.
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

    /**
     * Show the specified user's contributions page.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function contributions(User $user)
    {
        $images = $user->guitarImages()->get();
        $guitars = $user->contributedGuitars()->get();

        return view('profile.contributions', [
            'user'      => $user,
            'images'    => $images,
            'guitars'   => $guitars,
        ]);
    }
}
