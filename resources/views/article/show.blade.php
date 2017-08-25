@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 no-padding">
                    @include('partials.messages')
                </div>
            </div>
            <div class="row heading">
                <div class="col-md-10 col-md-offset-1">
                    <a href="{{ route('article.public.index') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-list"></span>@lang('content.article-overview')</a>
                    <a href="{{ route('article.public.index') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-list"></span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="dashboard-content">
                        <h2>{{ $article->title }}</h2>
                        <div class="article-author">
                            @if($article->created_at)
                                <span><i>{{ $article->user->fullName() . '-' . $article->created_at->formatLocalized('%A %d %B %Y') }}</i></span>
                            @else
                                <span><i>{{ $article->user->fullName() }} - @lang('content.long-time-ago')</i></span>
                            @endif
                        </div>
                        <br><br>
                        <div style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})" class="article-image"></div>
                        <br>
                        <p class="article-body">{!! nl2br(e($article->body)) !!}</p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="social-media-left">
                                    @lang('content.views', ['view-amount' => $article->views]) ·
                                    {{ $comments->total() }} @lang('content.comments')
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="social-media-right">
                                    <div class="g-plusone"></div>
                                    <a class="twitter-share-button" href="https://twitter.com/intent/tweet" data-size="large">Tweet</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($comments->isNotEmpty())
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="dashboard-content">
                            @foreach($comments as $comment)
                                <div id="comment-{{ $comment->id }}">
                                    <a href="{{ route('profile.show', ['user' => $comment->user->id]) }}"><span>{{ $comment->user->fullName() }}</span></a>
                                    @if($comment->created_at)
                                        &middot; <span class="time-ago">{{ $comment->created_at->diffForHumans() }}</span>
                                    @else
                                        &middot; <span class="time-ago">@lang('content.long-time-ago')</span>
                                    @endif
                                    @if(Auth::check() && Auth::user()->id === $comment->user->id)
                                        &middot; <span><a href="{{ route('comment.destroy', ['comment' => $comment->id]) }}" onclick="deleteItem({{ $comment->id }}, 'delete-comment');">@lang('content.remove')</a></span>
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
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        {{ $comments->links() }}
                    </div>
                </div>
            @endif
            @if(Auth::check())
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="dashboard-content">
                            <form action="{{ route('comment.store') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <div class="form-group {{ $errors->has('comment') ? ' has-error' : '' }}">
                                    @if ($errors->has('comment'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </span>
                                    @endif
                                    <textarea name="comment" cols="30" rows="5" class="form-control" placeholder="@lang('input.write-comment')"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary col-md-3" value="@lang('input.submit')">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="dashboard-content">
                            <h5>@lang('content.auth-comment') <a href="{{ route('login') }}">@lang('content.to-login')</a></h5>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('partials.dialog')
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
    @include('partials.dialog-js')
@endsection
