<?php

namespace App\Http\Controllers;

use App\CtaSection;
use Illuminate\Http\Request;
use App\Article;
Use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locale = LaravelLocalization::getCurrentLocale();

        $articles  = Article::where('lang', $locale)->take(3)->get();
        $cta_items = CtaSection::take(3)->get();

        return view('home', [
            'articles'  => $articles,
            'cta_items' => $cta_items,
        ]);
    }

    /**
     * Show the application disclaimer.
     *
     * @return \Illuminate\Http\Response
     */
    public function disclaimer()
    {
        return view('disclaimer');
    }
}
