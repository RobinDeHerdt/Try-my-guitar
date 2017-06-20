@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @if($articles->isNotEmpty())
                <h2 class="padding-top">Articles</h2>
                @foreach ($articles as $article)
                    @if($loop->index % 3 == 0)
                        <div class="row">
                            @endif
                            <div class="col-md-4">
                                <a href="{{ route('article.public.show', ['article' => $article->id, 'title' => str_slug($article->title)]) }}" class="article-link">
                                    <div class="article">
                                        <div class="article-teaser-image" style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})"></div>
                                        <div class="article-teaser">
                                            <h4>{{ $article->title }}</h4>
                                            <p>{{ str_limit($article->body, 200) }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @if($loop->index % 3 == 2)
                        </div>
                    @endif
                @endforeach
                {{ $articles->links() }}
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection