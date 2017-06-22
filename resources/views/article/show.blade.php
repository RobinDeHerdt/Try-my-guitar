@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 no-padding">
                    @if (Session::has('success-message'))
                        <div class="alert alert-success">{{ Session::get('success-message') }}</div>
                    @endif
                    @if (Session::has('info-message'))
                        <div class="alert alert-info">{{ Session::get('info-message') }}</div>
                    @endif
                </div>
            </div>
            <div class="row heading">
                <div class="col-md-10 col-md-offset-1 no-padding">
                    <a href="{{ route('article.public.index') }}" class="icon-text"><span class="glyphicon glyphicon-list"></span>Article overview</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1 dashboard-content">
                    <h2>{{ $article->title }}</h2>
                    <div class="article-author">
                        <span><i>{{ $article->user->fullName() }} - {{ $article->created_at ? $article->created_at->formatLocalized('%A %d %B %Y') : 'A long time ago' }}</i></span>
                    </div>
                    <br><br>
                    <div style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})" class="article-image"></div>
                    <br>
                    <p class="article-body">{!! nl2br(e($article->body)) !!}</p>
                    <hr>
                    <div class="social-media-left">
                        @lang('content.views', ['view-amount' => $article->views]) ·
                        {{ $comments->total() }} @lang('titles.comments')
                    </div>
                    <div class="social-media-right">
                        <div class="g-plusone"></div>
                        <a class="twitter-share-button" href="https://twitter.com/intent/tweet" data-size="large">Tweet</a>
                    </div>
                </div>
            </div>
            @if($comments->isNotEmpty())
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 dashboard-content">
                        @foreach($comments as $comment)
                            <div id="comment-{{ $comment->id }}">
                                <span>{{ $comment->user->fullName() }}</span>
                                &middot; <span class="time-ago">{{ $comment->created_at ? $comment->created_at->diffForHumans() : 'A long time ago' }}</span>
                                @if(Auth::check() && Auth::user()->id === $comment->user->id)
                                    &middot; <span><a href="{{ route('comment.destroy', ['comment' => $comment->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-comment-{{ $comment->id }}').submit();">Remove</a></span>
                                    <form action="{{ route('comment.destroy', ['comment' => $comment->id]) }}" method="POST" id="delete-comment-{{ $comment->id }}" style="display: none">
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                                <br><br>
                                <p>{{ $comment->body }}</p>
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 no-padding">
                        {{ $comments->links() }}
                    </div>
                </div>
            @else
                <div class="row padding-top">
                    <div class="col-md-10 col-md-offset-1 no-padding">
                        <h4>@lang('content.no-comments')</h4>
                    </div>
                </div>
            @endif
            @if(Auth::check())
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 dashboard-content">
                        <form action="{{ route('comment.store') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <div class="form-group">
                                <textarea name="comment" cols="30" rows="5" class="form-control" placeholder="@lang('input.write-comment')"></textarea>
                            </div>
                            <input type="submit" class="btn btn-primary col-md-3" value="@lang('input.submit')">
                        </form>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 dashboard-content">
                        <h5>@lang('content.auth-comment') <a href="{{ route('login') }}">@lang('content.to-login')</a></h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    <script>
        if(location.hash.slice(1)) {
            $('html,body').animate({
                scrollTop: $("#" + location.hash.slice(1)).offset().top - 80
            }, 1000 );
        }
    </script>
    <script>window.twttr = (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0],
                t = window.twttr || {};
            if (d.getElementById(id)) return t;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);

            t._e = [];
            t.ready = function(f) {
                t._e.push(f);
            };

            return t;
        }(document, "script", "twitter-wjs"));
    </script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
@endsection