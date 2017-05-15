<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the 'about' page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('about');
    }
}
