@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-8 col-md-offset-2 no-padding">
                    <a href="{{ route('article.public.index') }}" class="icon-text"><span class="glyphicon glyphicon-list"></span>Article overview</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2 dashboard-content">
                    <div style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})" class="article-image"></div>
                    <h2>{{ $article->title }}</h2>
                    <div class="article-author">
                        <span><i>{{ $article->user->fullName() .' - ' . $article->created_at }}</i></span>
                    </div>
                    <p class="article-body">{!! nl2br(e($article->body)) !!}</p>
                    <hr>
                    <div class="social-media-left">
                        {{ $article->views }} views
                    </div>
                    <div class="social-media-right">
                        <div class="g-plusone"></div>
                        <a class="twitter-share-button" href="https://twitter.com/intent/tweet" data-size="large">Tweet</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2>Comments ({{ $comments->total() }})</h2>
                </div>
            </div>
            @foreach($comments as $comment)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 dashboard-content">
                        <h4>{{ $comment->user->fullName() }}</h4>
                        <p>{{ $comment->body }}</p>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-md-8 col-md-offset-2 no-padding">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
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