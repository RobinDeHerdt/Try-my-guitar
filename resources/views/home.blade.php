@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="header-content">
            <h1>Try my guitar</h1>
            <div class="header-search">
                <form class="form-inline" id="search-form" method="GET" action="{{ route('search') }}">
                    <input type="text" class="form-control search-input" name="term" id="search-input" placeholder="@lang('input.user-search')" value="{{app('request')->input('term') }}">
                    <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit" onclick="event.preventDefault(); document.getElementById('search-form').submit();">@lang('input.search')</a>
                    <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit-mobile" onclick="event.preventDefault(); document.getElementById('search-form').submit();"><i class="fa fa-search" aria-hidden="true"></i></a>
                </form>
            </div>
        </div>
        <div class="header-image" style="background-image: url('/images/frontpage-bg.jpg'); background-position: top"></div>
        <div class="container">
            <h2 class="padding-top">@lang('titles.how-it-works')</h2>
            <div class="row">
                @foreach($cta_items as $cta_item)
                <div class="col-md-4">
                    <div class="cta-item">
                        <i class="fa {{ $cta_item->icon_class }} fa-4x" aria-hidden="true"></i>
                        <p>{{ $cta_item->{"content_" . LaravelLocalization::getCurrentLocale()} }}</p>
                        <a href="about#{{ strtolower(kebab_case($cta_item->title)) }}" class="cta-button text-uppercase">@lang('input.read-more')</a>
                    </div>
                </div>
                @endforeach
            </div>
            @if($articles->isNotEmpty())
                <h2 class="padding-top">@lang('titles.latest-news')</h2>
                <div class="row">
                    @foreach ($articles as $article)
                        <div class="col-md-4">
                            <a href="{{ route('article.public.show', ['article' => $article->id, 'title' => str_slug($article->title)]) }}" class="article-link">
                                <div class="article">
                                    <div class="article-teaser-image" style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})"></div>
                                    <div class="article-teaser">
                                        <h4>{{ $article->title }}</h4>
                                        <p>{{ str_limit($article->body, 150) }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                @if($articles->count() > 3)
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="big-cta-button">
                                <a href="{{ route('article.public.index') }}" class="text-uppercase">@lang('input.read-more')</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    <script>
        $( "#search-input" ).autocomplete({
            source: "{{ route('search.autocomplete') }}",
            minLength: 1,
            autoFocus:true,
            select: function (event, ui) {
                $('#search-input').val(ui.item.value);
                $('#search-form').submit();
            }
        });
    </script>
    @include('partials.analytics')
@endsection