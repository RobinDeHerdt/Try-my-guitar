<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate(15);

        return view('admin.article.index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Display a listing of trashed articles.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $articles = Article::onlyTrashed()->paginate(15);

        return view('admin.article.trashed', [
            'articles' => $articles,
        ]);
    }

    /**
     * Restore a trashed article.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Article::onlyTrashed()->find($id)->restore();

        Session::flash('success-message', 'Article restored successfully.');

        return back();
    }

    /**
     * Move article to trash (soft delete).
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        Session::flash('info-message', 'Article was moved to trash.');

        return redirect(route('articles.index'));
    }
}
