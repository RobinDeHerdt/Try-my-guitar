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
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-content">
                        <div class="slick-main">
                            @foreach($guitar->guitarImages as $guitarImage)
                                <div class="slick-item">
                                    <img src="{{ Storage::disk('public')->url($guitarImage->image_uri) }}">
                                    <span><strong>{{ $guitarImage->user->fullName() }}</strong></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>More {{ $guitar->guitarBrand->name }} guitars</h2>
                    <div class="slick-related">
                        @foreach($guitar->guitarBrand->guitars->except(['id' => $guitar->id]) as $guitarBrandGuitar)
                            <a href="{{ route('guitar.show', ['guitar' => $guitarBrandGuitar->id]) }}">
                            <div class="slick-item">
                                <img src="{{ Storage::disk('public')->url($guitarBrandGuitar->guitarImages->first()->image_uri) }}">
                                <span><strong>{{ $guitarBrandGuitar->name }}</strong></span>
                            </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
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
            lazyLoad: 'ondemand',
            arrows: true,
            dots: true,
            variableWidth: true,
            adaptiveHeight: true,
            centerMode: true,
        });
    </script>
@endsection
