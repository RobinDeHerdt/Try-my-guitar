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
                    <input type="text" class="form-control search-input" name="term" id="search-input" placeholder="Search for a user or guitar" value="{{app('request')->input('term') }}">
                    <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit" onclick="event.preventDefault(); document.getElementById('search-form').submit();">Search</a>
                    <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit-mobile" onclick="event.preventDefault(); document.getElementById('search-form').submit();"><i class="fa fa-search" aria-hidden="true"></i></a>
                </form>
            </div>
        </div>
        <div class="header-image" style="background-image: url('/images/register-bg.jpg');"></div>
        <div class="container">
            <div class="row padding-top">
                <h2>@lang('titles.how-does-it-work')</h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="cta-item">
                        <i class="fa fa-user-plus fa-4x" aria-hidden="true"></i>
                        <p>Get to know guitar players in your area, and by extension, their guitar! Arrange a meet-up up in person and rock out together!</p>
                        <a href="about#about-1" class="cta-button text-uppercase">Read more</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cta-item">
                        <i class="fa fa-search fa-4x" aria-hidden="true"></i>
                        <p>Discover guitars and read about other people's experiences with them.</p>
                        <a href="about#about-2" class="cta-button text-uppercase">Read more</a>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="cta-item">
                        <i class="fa fa-users fa-4x" aria-hidden="true"></i>
                        <p>Crowd sourced collection of all guitars in existance.</p>
                        <a href="about#about-3" class="cta-button text-uppercase">Read more</a>
                    </div>
                </div>
            </div>
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
                            <a href="#" class="text-uppercase">Read more</a>
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