<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use App\User;

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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

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
        $user = $this->user;

        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->email        = $request->email;
        $user->location     = $request->location;

        if (isset($request->image)) {
            $user->image_uri = $request->image->store('images', 'public');
        }

        $user->save();

        Session::flash('success-message', 'Profile updated successfully.');

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
