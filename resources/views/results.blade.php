@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="search-results-search">
                @include('partials.search')
            </div>
            <h2>Users</h2>
            <hr class="dark-hr">
            <div class="row">
                @if($users->isNotEmpty())
                    @foreach($users as $user)
                        <div class="col-md-6">
                            <div class="search-result">
                                <a href="{{ route('profile.show', ['id' => $user->id]) }}">
                                <div class="search-result-overlay">
                                    <span class="search-result-overlay-text">View profile</span>
                                </div>
                                </a>
                                <div class="search-result-image" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})"></div>
                                <h3>{{ $user->fullName()  }}</h3>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-results">
                        <h4>No results found.</h4>
                    </div>
                @endif
            </div>
            <h2>Guitars</h2>
            <hr class="dark-hr">
            <div class="row">
                @if($guitars->isNotEmpty())
                    @foreach($guitars as $guitar)
                        <div class="col-md-6">
                            <div class="search-result">
                                <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}">
                                    <div class="search-result-overlay">
                                        <span class="search-result-overlay-text">View profile</span>
                                    </div>
                                </a>
                                <div class="search-result-image" style="background-image: url({{ Storage::disk('public')->url($guitar->image_uri) }})"></div>
                                <h3>{{ $guitar->name }}</h3>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-results">
                        <h4>No results found.</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
