@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Search results for "{{ $search_term }}"</h1>
                </div>
            </div>
            <h2>Users</h2>
            <hr class="dark-hr">
            @if($users->isNotEmpty())
                @foreach($users as $user)
                    @if($loop->index % 2 === 0)
                        <div class="row">
                    @endif
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
                    @if($loop->index % 2 === 1)
                        </div>
                    @endif
                @endforeach
            @else
                <div class="no-results">
                    <h4>No results found.</h4>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
