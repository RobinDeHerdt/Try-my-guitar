<?php

namespace App\Http\Controllers;

use App\CtaItem;
use Illuminate\Http\Request;

/**
 * Class AboutController
 * @package App\Http\Controllers
 */
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
