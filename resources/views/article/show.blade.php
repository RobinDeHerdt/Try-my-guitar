@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 dashboard-content">
                    <div style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})" class="article-image"></div>
                    <h2>{{ $article->title }}</h2>
                    <div class="article-author">
                        <span><i>{{ $article->user->fullName() .' - ' . $article->created_at }}</i></span>
                    </div>
                    <p class="article-body">{!! nl2br(e($article->body)) !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection