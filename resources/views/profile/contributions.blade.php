@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @if (Session::has('success-message'))
                <div class="alert alert-success alert-margin">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info alert-margin">{{ Session::get('info-message') }}</div>
            @endif
            @if (Session::has('error-message'))
                <div class="alert alert-danger alert-margin">{{ Session::get('error-message') }}</div>
            @endif
            <div class="row heading">
                <div class="col-md-12">
                    <h1>{{ $user->first_name }}'s contributions</h1>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-user"></span>View {{ $user->first_name }}'s profile</a>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-user"></span></a>
                </div>
            </div>
            @if($guitars->isNotEmpty() || $images->isNotEmpty())
                @if($guitars->isNotEmpty())
                    <h3>Guitars</h3>
                    <div class="row">
                        @foreach($guitars as $guitar)
                            <div class="col-md-6">
                                <div class="search-result">
                                    <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}">
                                        <div class="search-result-overlay">
                                            <span class="search-result-overlay-text">@lang('content.view-details')</span>
                                        </div>
                                    </a>
                                    <img src="{{ Storage::disk('public')->url($guitar->guitarBrand->logo_uri) }}" alt="{{ $guitar->guitarBrand->name }} logo" class="search-result-logo">
                                    @if($guitar->guitarImages->isNotEmpty())
                                        <img src="{{ Storage::disk('public')->url($guitar->guitarImages()->first()->image_uri) }}" class="search-result-image">
                                    @else
                                        <div class="search-result-image">No image available</div>
                                    @endif
                                    <h3>{{ $guitar->name }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if($images->isNotEmpty())
                    <h3 class="padding-top">Images</h3>
                    <div class="row">
                        @foreach($images as $image)
                            <div class="col-md-6">
                                <div class="search-result">
                                    <img src="{{ Storage::disk('public')->url($image->image_uri) }}" class="search-result-image">
                                    @if(Auth::check() && Auth::user()->id === $user->id)
                                        <hr>
                                        <div class="center-content">
                                            <a href="{{ route('guitar.image.destroy', ['guitarImage' => $image->id]) }}" onclick="event.preventDefault(); document.getElementById('guitar-image-{{ $guitar->id }}').submit();">Remove</a>
                                        </div>
                                        <form action="{{ route('guitar.image.destroy', ['guitarImage' => $image->id]) }}" method="POST" id="guitar-image-{{ $guitar->id }}">
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else

                @endif
            @else
                <h4>Nothing to see here (yet).</h4>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    <script>
    @include('partials.analytics')
@endsection
