<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Comment;
use App\Article;
use Auth;

/**
 * Class CommentController
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{
    /**
     * Contains the authenticated user.
     *
     * @var \App\User
     */
    private $user;

    /**
     * Constructor.
     *
     * Check if the user has the 'user' role.
     * Get the authenticated user and save it to the $user variable.
     */
    public function __construct()
    {
        $this->middleware('role:user')->except('show');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Store the created comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'article_id' => 'required|numeric',
            'comment' => 'required|max:1024',
        ]);

        $article = Article::find($request->article_id);

        if ($article) {
            $comment = new Comment();

            $comment->user_id       = $this->user->id;
            $comment->body          = $request->comment;
            $comment->article_id    = $request->article_id;

            $comment->save();

            return redirect(route('article.public.show', [
                    'article' => $article,
                    'title' => str_slug($article->title)
                ]). "#comment-" . $comment->id);
        }

        return redirect(route('article.public.show', [
                'article'   => $article,
                'title'     => str_slug($article->title)
        ]));
    }

    /**
     * Remove the specified comment.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user->id === $this->user->id) {
            $comment->delete();

            Session::flash('success-message', __('flash.comment-removed'));

            return back();
        } else {
            abort(403);
        }
    }
}
