<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function index()
    {
        $user       = Auth::user();
        $channels   = $user->channels()->get();

        return view('profile', [
            'channels' => $channels,
            'user' => $user,
        ]);
    }
}
