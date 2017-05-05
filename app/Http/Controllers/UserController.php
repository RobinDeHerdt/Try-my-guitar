<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function show()
    {
        return Auth::user()->id;
    }
}
