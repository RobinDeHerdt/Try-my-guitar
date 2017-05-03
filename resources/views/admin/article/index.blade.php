@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row admin-heading">
            <h1>Article overview</h1>
            <a href="{{ route('articles.create') }}" class="icon-text"><span class="glyphicon glyphicon-plus"></span>Create article</a>
            <a href="{{ route('articles.trashed') }}" class="icon-text"><span class="glyphicon glyphicon-trash"></span>View thrashed articles</a>
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
                        <th>Delete</th>
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
                            <td class="center-icon"><a href="{{ route('articles.destroy', ['id' => $article->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-article-{{ $article->id }}-form').submit();"><span class="glyphicon glyphicon-trash"></span></a>
                                <form id="delete-article-{{ $article->id }}-form" action="{{ route('articles.destroy', ['id' => $article->id]) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $articles->links() }}
        @else
            <div class="no-results">
                <h4>No articles to be displayed</h4>
            </div>
        @endif
    </div>
@endsection
