@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row admin-heading">
        <div class="col-md-12">
            <h1>{{ $article->title }}</h1>
            <a href="{{ route('articles.index') }}" class="icon-text"><span class="glyphicon glyphicon-home"></span>Back to overview</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>{!! nl2br(e($article->body)) !!}</p>
            </div>
            <div class="col-md-6">
                <div style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})" class="admin-image"></div>
            </div>
        </div>
        <div class="row admin-footer">
            <div class="col-md-12">
                <a href="{{ route('articles.destroy', ['id' => $article->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-article-form').submit();" class="icon-text"><span class="glyphicon glyphicon-trash"></span>Trash</a>
                <form id="delete-article-form" action="{{ route('articles.destroy', ['id' => $article->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>
                <a href="{{ route('articles.edit', ['id' => $article->id]) }}" class="icon-text"><span class="glyphicon glyphicon-pencil"></span>Edit</a>
            </div>
        </div>
    </div>
@endsection
