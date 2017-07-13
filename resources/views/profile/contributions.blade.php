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
                    <h1>@lang('content.s-contributions', ['name' => $user->first_name])</h1>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-user"></span>@lang('content.view-name-profile', ['name' => $user->first_name])</a>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-user"></span></a>
                </div>
            </div>
            @if($guitars->isNotEmpty() || $images->isNotEmpty())
                @if($guitars->isNotEmpty())
                    <h3>@lang('titles.guitars')</h3>
                    <div class="row">
                        @foreach($guitars as $guitar)
                            <div class="col-md-6">
                                <div class="search-result">
                                    @if($guitar->guitarImages->isNotEmpty())
                                        <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}">
                                            <img src="{{ Storage::disk('public')->url($guitar->guitarImages()->first()->image_uri) }}" class="search-result-image">
                                        </a>
                                    @else
                                        <div class="search-result-image no-image"><span>@lang('content.no-image')</span></div>
                                    @endif
                                    <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}" class="no-decoration on-top">
                                        <h3>{{ $guitar->name }}</h3>
                                    </a>
                                    @if(Auth::check() && Auth::user()->id === $user->id)
                                        <hr>
                                        <div class="center-content">
                                            <a href="{{ route('guitar.destroy', ['guitar' => $guitar->id]) }}" onclick="event.preventDefault(); document.getElementById('guitar-{{ $guitar->id }}').submit();">@lang('content.remove')</a>
                                        </div>
                                        <form action="{{ route('guitar.destroy', ['guitar' => $guitar->id]) }}" method="POST" id="guitar-{{ $guitar->id }}">
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if($images->isNotEmpty())
                    <h3 class="padding-top">@lang('titles.images')</h3>
                    <div class="row">
                        @foreach($images as $image)
                            <div class="col-md-6">
                                <div class="search-result">
                                    <img src="{{ Storage::disk('public')->url($image->image_uri) }}" class="search-result-image">
                                    @if(Auth::check() && Auth::user()->id === $user->id)
                                        <hr>
                                        <div class="center-content">
                                            <a href="{{ route('guitar.image.destroy', ['guitarImage' => $image->id]) }}" onclick="event.preventDefault(); document.getElementById('guitar-image-{{ $image->id }}').submit();">@lang('content.remove')</a>
                                        </div>
                                        <form action="{{ route('guitar.image.destroy', ['guitarImage' => $image->id]) }}" method="POST" id="guitar-image-{{ $image->id }}">
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
                <h4>@lang('content.nothing-to-see-here')</h4>
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
