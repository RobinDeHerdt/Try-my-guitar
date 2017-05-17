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
            <div class="row heading">
                <div class="col-md-12">
                    <h1>{{ $guitar->guitarBrand->name }} (logo: {{ $guitar->guitarBrand->logo_uri }}){{ $guitar->name }}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="slick-test">
                        @foreach($guitar->guitarImages as $guitarImage)
                            <img src="{{ Storage::disk('public')->url($guitarImage->image_uri) }}">
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h3>Images:</h3>
                    @foreach($guitar->guitarImages as $guitarImage)
                        <span>{{ $guitarImage->image_uri }}</span><br>
                    @endforeach
                </div>
                <div class="col-md-6">
                    <h3>Types:</h3>
                    @foreach($guitar->guitarTypes as $guitarType)
                        <span>{{ $guitarType->name }}</span><br>
                    @endforeach
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
        $('.slick-test').slick({

        });
    </script>
@endsection
