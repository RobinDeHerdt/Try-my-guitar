<?php

namespace App\Http\Controllers;

use App\Article;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    /**
     * Display a listing of articles (for administrators).
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
     * Display a listing of articles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexPublic(Request $request)
    {
        $article_query = Article::select('*');

        switch ($request->query('sort')) {
            case 'oldest':
                $article_query->orderBy('created_at', 'asc');
                break;

            default:
                $article_query->orderBy('created_at', 'desc');
        }

        switch ($request->query('lang')) {
            case 'nl':
                $article_query->where('lang', 'nl');
                break;

            case 'en':
                $article_query->where('lang', 'en');
                 break;
        }

        $articles = $article_query->paginate(6);

        // Append all query parameters that were received with the initial request.
        foreach (Input::except('page') as $input => $value) {
            $articles->appends($input, $value);
        }

        return view('article.index', [
            'articles' => $articles,
            'sort_filter' => $request->query('sort'),
            'lang_filter' => $request->query('lang'),
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
        $article->lang      = $request->language;
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
    public function showPublic(Article $article)
    {
        // @todo Save viewed article id's in an array and store it in session.
        // Make sure views doesn't increment with every single page view.
        $article->views++;
        $article->save();

        $comments = $article->comments()->paginate(8);

        Carbon::setLocale(LaravelLocalization::getCurrentLocale());

        return view('article.show', [
            'article'   => $article,
            'comments'  => $comments,
        ]);
    }

    /**
     * Display the specified article (admin section).
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
     * Show the form for editing the specified article.
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
     * Update the specified article.
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
        $article->lang      = $request->language;

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
     * Restore a specified trashed article.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Article::onlyTrashed()->find($id)->restore();

        Session::flash('success-message', 'Article restored successfully.');

        return back();
    }

    /**
     * Move specified article to trash.
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
