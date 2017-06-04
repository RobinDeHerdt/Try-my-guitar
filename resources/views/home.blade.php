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
        <div class="header-image" style="background-image: url('/images/register-bg.jpg');"></div>
        <div class="container">
            @if($cta_items->count() === 3)
                <h2 class="padding-top">@lang('titles.how-it-works')</h2>
                <div class="row">
                    @foreach($cta_items as $cta_item)
                    <div class="col-md-4">
                        <div class="cta-item">
                            <i class="fa {{ $cta_item->cta_icon_class }} fa-4x" aria-hidden="true"></i>
                            <p>{{ $cta_item->cta_text }}</p>
                            <a href="about#{{ strtolower(kebab_case($cta_item->title)) }}" class="cta-button text-uppercase">@lang('input.read-more')</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
            @if($articles->isNotEmpty())
                <h2 class="padding-top">@lang('titles.latest-news')</h2>
                @foreach ($articles as $article)
                    @if($loop->index % 3 == 0)
                        <div class="row">
                    @endif
                        <div class="col-md-4">
                            <div class="article">
                                <div class="article-teaser-image" style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})"></div>
                                <div class="article-teaser">
                                    <h4>{{ $article->title }}</h4>
                                    <p>{{ $article->body }}</p>
                                </div>
                            </div>
                        </div>
                    @if($loop->index % 3 == 2)
                        </div>
                    @endif
                @endforeach
                <div class="row padding-top">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="big-cta-button">
                            <a href="#" class="text-uppercase">@lang('input.read-more')</a>
                        </div>
                    </div>
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