<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function index()
    {
        $user = Auth::user();

        return view('profile.index', [
            'user' => $user,
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
}
