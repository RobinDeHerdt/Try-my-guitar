<?php

namespace App\Http\Controllers;

use App\CtaItem;
use Illuminate\Http\Request;
use App\Article;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Show the 'home' page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locale = LaravelLocalization::getCurrentLocale();

        $articles  = Article::where('lang', $locale)->take(3)->get();
        $cta_items = CtaItem::where('active', true)->take(3)->get();

        return view('home', [
            'articles'  => $articles,
            'cta_items' => $cta_items,
        ]);
    }

    /**
     * Show the 'disclaimer' page.
     *
     * @return \Illuminate\Http\Response
     */
    public function disclaimer()
    {
        return view('disclaimer');
    }
}
