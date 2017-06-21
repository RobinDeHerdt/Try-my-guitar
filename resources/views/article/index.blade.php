@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>@lang('titles.article-overview')</h1>
                    <form action="{{ route('article.public.index') }}" method="GET" id="article-filter">
                        <div class="icon-text">
                            <div class="form-group">
                                <select class="form-control" id="sort-selector" name="sort">
                                    <option value="newest" {{ $sort_filter === 'newest' ? 'selected' : '' }}>Newest first</option>
                                    <option value="oldest" {{ $sort_filter === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                                </select>
                            </div>
                        </div>
                        <div class="icon-text">
                            <div class="form-group">
                                <select class="form-control" id="lang-selector"name="lang">
                                    <option value="all" {{ $lang_filter === 'all' ? 'selected' : '' }}>All languages</option>
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <option value="{{ $localeCode }}" {{ $lang_filter === $localeCode ? 'selected' : '' }}>{{ $properties['native'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if($articles->isNotEmpty())
                <div class="row">
                    @foreach ($articles as $article)
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
                    @endforeach
                    {{ $articles->links() }}
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
        $("#lang-selector").change(function() {
            $('#article-filter').submit();
        });

        $("#sort-selector").change(function() {
            $('#article-filter').submit();
        });
    </script>
@endsection