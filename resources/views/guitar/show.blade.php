@extends('layouts.app')

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
