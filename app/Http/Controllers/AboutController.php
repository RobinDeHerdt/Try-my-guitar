<?php

namespace App\Http\Controllers;

use App\AboutSection;
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
        $about_sections = AboutSection::all();

        return view('about', [
            'about_sections' => $about_sections,
        ]);
    }

    /**
     * Show the form for creating a new about section.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.about.create');
    }

    /**
     * Store a newly created article.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = new Article();

        $article->user_id   = Auth::user()->id;

        $article->title     = $request->title;
        $article->body      = $request->body;
        $article->image_uri = $request->image->store('images', 'public');

        $article->save();

        Session::flash('success-message', 'Article created successfully.');

        return redirect(route('articles.index'));
    }
}
