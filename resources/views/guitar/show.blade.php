@extends('layouts.app')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css"/>
@endsection

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="dashboard-content">
                        <img src="{{ Storage::disk('public')->url($guitar->guitarBrand->logo_uri) }}" alt="{{ $guitar->guitarBrand->name }} logo" class="guitar-brand-logo">
                        <h1>{{ $guitar->guitarBrand->name }} {{ $guitar->name }}</h1>
                        <div class="guitar-type-container">
                            @foreach($guitar->guitarTypes as $guitarType)
                                <span class="guitar-type">{{ $guitarType->name }}</span>
                            @endforeach
                        </div>
                        <div class="guitar-description-container">
                            {{ $guitar->description }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-content">
                        <div class="slick-main">
                            @foreach($guitar->guitarImages as $guitarImage)
                                <div class="slick-item">
                                    <img src="{{ Storage::disk('public')->url($guitarImage->image_uri) }}">
                                    <span>By <a href="{{  route('profile.show', ['id' => $guitarImage->user->id]) }}"><strong>{{ $guitarImage->user->fullName() }}</strong></a></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-content">
                <h2>People who own this guitar</h2>
                <div class="collection">
                    @foreach($users as $user)
                        <div class="collection-item">
                            <a href="{{ route('profile.show', ['user' => $user->id]) }}" title="{{ $user->fullName() }}">
                                <div style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }}" class="collection-item-image"></div>
                                <span class="collection-item-text">{{ $user->fullName() }}</span>
                            </a>
                        </div>
                    @endforeach
                    @if($user_count > 4)
                        <div class="collection-item">
                            <a href="{{ route('guitar.show.users', ['guitar' => $guitar->id]) }}">
                                <div class="collection-item-color">
                                    <div class="collection-more" title="View all people with this guitar">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <span>{{ $user_count - 4 }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @if($brand_guitars->isNotEmpty())
            <div class="row">
                <div class="col-md-12">
                    <h2>More {{ $guitar->guitarBrand->name }} guitars</h2>
                    <div class="slick-related">
                        @foreach($brand_guitars as $brand_guitar)
                            <a href="{{ route('guitar.show', ['guitar' => $brand_guitar->id]) }}">
                            <div class="slick-item">
                                @if($brand_guitar->guitarImages->isNotEmpty())
                                    <img src="{{ Storage::disk('public')->url($brand_guitar->guitarImages->first()->image_uri) }}">
                                @else
                                    <div class="search-result-image">No image available</div>
                                @endif
                                <span class="guitar-link"><strong>{{ $brand_guitar->name }}</strong></span>
                            </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if($similar_guitars->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <h2>Similar guitars</h2>
                        <div class="slick-related">
                            @foreach($similar_guitars as $similar_guitar)
                                <a href="{{ route('guitar.show', ['guitar' => $similar_guitar->id]) }}">
                                    <div class="slick-item">
                                        @if($similar_guitar->guitarImages->isNotEmpty())
                                            <img src="{{ Storage::disk('public')->url($similar_guitar->guitarImages->first()->image_uri) }}">
                                        @else
                                            <div class="search-result-image">No image available</div>
                                        @endif
                                        <span class="guitar-link"><strong>{{ $similar_guitar->name }}</strong></span>
                                    </div>
                                </a>
                            @endforeach
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
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script>
        $('.slick-main').slick({
            lazyLoad: 'ondemand',
            infinite: true,
            arrows: false,
            dots: true,
            variableWidth: true,
            adaptiveHeight: true,
            centerMode: true,
            autoplay: true,
            autoplaySpeed: 5000,
        });

        $('.slick-related').slick({
            arrows: true,
            infinite: false,
            variableWidth: true,
        });
    </script>
@endsection
