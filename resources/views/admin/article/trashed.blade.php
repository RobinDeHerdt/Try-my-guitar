@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @include('partials.messages')
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Trashed articles</h1>
                    <a href="{{ route('articles.index') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-list"></span>Back to overview</a>
                    <a href="{{ route('articles.index') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-list"></span></a>
                </div>
            </div>
            @if($articles->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Content</th>
                            <th>Image</th>
                            <th class="center">Restore</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td>{{ str_limit($article->title, 30) }}</td>
                                <td>{{ $article->user->first_name . ' ' . $article->user->last_name}}</td>
                                <td>{{ str_limit($article->body, 65)}}</td>
                                <td><a href="{{ Storage::disk('public')->url($article->image_uri) }}">View image</a></td>
                                <td class="center"><a href="{{ route('articles.restore', ['id' => $article->id]) }}" onclick="event.preventDefault(); document.getElementById('restore-article-{{ $article->id }}-form').submit();"><span class="glyphicon glyphicon-repeat"></span></a>
                                    <form id="restore-article-{{ $article->id }}-form" action="{{ route('articles.restore', ['id' => $article->id]) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $articles->links() }}
            @else
                <div class="no-results">
                    <h4>Trash is empty</h4>
                </div>
            @endif
        </div>
    </div>
@endsection
