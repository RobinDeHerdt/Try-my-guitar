@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row admin-heading">
            <h1>Trashed articles</h1>
            <a href="{{ route('articles.index') }}" class="icon-text"><span class="glyphicon glyphicon-home"></span>Back to overview</a>
        </div>
        @if (Session::has('success-message'))
            <div class="alert alert-success">{{ Session::get('success-message') }}</div>
        @endif
        @if (Session::has('info-message'))
            <div class="alert alert-info">{{ Session::get('info-message') }}</div>
        @endif
        @if($articles->isNotEmpty())
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Restore</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ str_limit($article->body, 75)}}</td>
                        <td><a href="{{ $article->image_uri }}">View image</a></td>
                        <td class="center-icon"><a href="{{ route('articles.show', ['id' => $article->id]) }}"><span class="glyphicon glyphicon-search"></span></a></td>
                        <td class="center-icon"><a href="{{ route('articles.edit', ['id' => $article->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                        <td class="center-icon"><a href="{{ route('articles.restore', ['id' => $article->id]) }}" onclick="event.preventDefault(); document.getElementById('restore-article-{{ $article->id }}-form').submit();"><span class="glyphicon glyphicon-repeat"></span></a>
                            <form id="restore-article-{{ $article->id }}-form" action="{{ route('articles.restore', ['id' => $article->id]) }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $articles->links() }}
        @else
            <div class="no-results">
                <h4>Trash is empty</h4>
            </div>
        @endif
    </div>
@endsection
