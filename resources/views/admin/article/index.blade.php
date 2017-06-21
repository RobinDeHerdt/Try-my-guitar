@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Article overview</h1>
                    <a href="{{ route('articles.create') }}" class="icon-text"><span class="glyphicon glyphicon-plus"></span>Create article</a>
                    <a href="{{ route('articles.trashed') }}" class="icon-text"><span class="glyphicon glyphicon-trash"></span>View trashed articles</a>
                </div>
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
                            <th>Language</th>
                            <th>Author</th>
                            <th>Content</th>
                            <th>Image</th>
                            <th class="center">View</th>
                            <th class="center">Edit</th>
                            <th class="center">Trash</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td>{{ str_limit($article->title, 25) }}</td>
                                <td>{{ $article->lang }}</td>
                                <td>{{ $article->user->fullName() }}</td>
                                <td>{{ str_limit($article->body, 50) }}</td>
                                <td><a href="{{ Storage::disk('public')->url($article->image_uri) }}">View image</a></td>
                                <td class="center"><a href="{{ route('articles.show', ['id' => $article->id]) }}"><span class="glyphicon glyphicon-search"></span></a></td>
                                <td class="center"><a href="{{ route('articles.edit', ['id' => $article->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                <td class="center"><a href="{{ route('articles.destroy', ['id' => $article->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-article-{{ $article->id }}-form').submit();"><span class="glyphicon glyphicon-trash"></span></a>
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
    </div>
@endsection
