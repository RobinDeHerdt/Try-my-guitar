@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content white-bg">
        <div class="header-content">
            <h1>Try my guitar</h1>
            <div class="header-search">
                <form class="form-inline">
                    <input type="text" class="form-control search-input" name="search-term" placeholder="Search for a user or guitar">
                    <a href="#" class="btn btn-default search-submit" id="search-submit">Search</a>
                    <a href="#" class="btn btn-default search-submit" id="search-submit-mobile"><i class="fa fa-search" aria-hidden="true"></i></a>
                </form>
            </div>
        </div>
        <div class="header-image" style="background-image: url('/images/register-bg.jpg');"></div>
        <div class="container">
            <div class="row row-padding-top">
                <h2>@lang('titles.how-does-it-work')</h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="cta-item">
                        <i class="fa fa-music fa-4x" aria-hidden="true"></i>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae consectetur ex. Donec non sollicitudin erat. Aenean libero massa, lobortis eu consequat non, sollicitudin nec diam</p>
                        <a href="#" class="cta-button text-uppercase">Read more</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cta-item">
                        <i class="fa fa-music fa-4x" aria-hidden="true"></i>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae consectetur ex. Donec non sollicitudin erat. Aenean libero massa, lobortis eu consequat non, sollicitudin nec diam</p>
                        <a href="#" class="cta-button text-uppercase">Read more</a>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="cta-item">
                        <i class="fa fa-music fa-4x" aria-hidden="true"></i>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae consectetur ex. Donec non sollicitudin erat. Aenean libero massa, lobortis eu consequat non, sollicitudin nec diam</p>
                        <a href="#" class="cta-button text-uppercase">Read more</a>
                    </div>
                </div>
            </div>
            @if($articles->isNotEmpty())
            <div class="row row-padding-top">
                <h2>@lang('titles.latest-news')</h2>
                @foreach ($articles as $article)
                    <div class="col-md-4">
                        <div class="article">
                            <div class="article-teaser-image" style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})"></div>
                            <div class="article-teaser">
                                <h4>{{ $article->title }}</h4>
                                <p>{{ $article->body }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row row-padding-top">
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
