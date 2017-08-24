<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
    * Display a listing of users.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $users = User::orderBy('first_name', 'asc')->paginate(20);

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }
}
