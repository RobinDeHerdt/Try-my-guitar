<?php

namespace App\Http\Controllers;

use App\AboutSection;
use Illuminate\Http\Request;
use App\Article;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles  = Article::all()->take(6);
        $cta_items = AboutSection::where('show_cta', true)->take(3)->get();

        return view('home', [
            'articles' => $articles,
            'cta_items' => $cta_items,
        ]);
    }
}
