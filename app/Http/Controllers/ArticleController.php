<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Support\Facades\Auth;
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
     * Show the form for creating a new article.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.create');
    }

    /**
     * Store a newly created article in storage.
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

    /**
     * Display the specified article.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('admin.article.show', [
            'article' => $article,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.article.edit', [
            'article' => $article,
        ]);
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
        $article->user_id   = Auth::user()->id;

        $article->title     = $request->title;
        $article->body      = $request->body;

        if (isset($request->image)) {
            $article->image_uri = $request->image->store('images', 'public');
        }

        $article->save();

        Session::flash('success-message', 'Article updated successfully.');

        return redirect(route('articles.show', ['id' => $article->id]));
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