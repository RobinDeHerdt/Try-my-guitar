<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    /**
     * Display the administrator control panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
