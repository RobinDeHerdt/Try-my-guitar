@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row heading">
                <div class="col-md-12">
                    <h1>{{ $user->first_name }}'s collection</h1>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text"><span class="glyphicon glyphicon-user"></span>View {{ $user->first_name }}'s profile</a>
                </div>
                @foreach($user->guitars as $guitar)
                    <div class="col-md-6">
                        <div class="search-result">
                            <h3>{{ $guitar->name }}</h3>
                            <br>
                            @if($guitar->guitarImages->isNotEmpty())
                                <img src="{{ Storage::disk('public')->url($guitar->guitarImages()->first()->image_uri) }}" class="search-result-image">
                            @else
                                <div class="search-result-image">No image available</div>
                            @endif
                            <hr>
                            <div class="collection-experience">
                                <p>{{ $guitar->pivot->experience }}</p>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5 col-md-offset-1">
                                    <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}">View guitar</a>
                                </div>
                                @if(Auth::check() && Auth::user()->id === $user->id)
                                    <div class="col-md-5">
                                        <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}">Edit</a>
                                    </div>
                                @else
                                    <div class="col-md-5">
                                        <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}" class="cta-button green" title="Mark this experience as helpful"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                                        <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}" class="cta-button red" title="Mark this experience as not helpful"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    @include('partials.analytics')
@endsection
