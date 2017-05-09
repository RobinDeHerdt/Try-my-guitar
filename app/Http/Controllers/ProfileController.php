<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('profile.show', [
            'user' => $user
        ]);
    }

    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->email        = $request->email;

        if (isset($request->image)) {
            $user->image_uri = $request->image->store('images', 'public');
        }

        $user->save();

        Session::flash('success-message', 'Profile updated successfully.');

        return back();
    }

    public function invite($id)
    {
        $user = User::find($id);

        $auth_user = Auth::user();
        $channels = $auth_user->channels()->get();

        return view('profile.invite', [
            'user' => $user,
            'channels' => $channels,
        ]);
    }
}
