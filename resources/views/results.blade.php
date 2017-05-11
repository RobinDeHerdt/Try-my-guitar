@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content padding-top">
        <div class="container">
            <h1>Search results for "{{ $search_term }}"</h1>
            <h3>Users</h3>

            <div class="row">
                @foreach($users as $user)
                    <div ></div>
                    <a href="{{ route('profile.show', ['id' => $user->id]) }}">{{ $user->fullName()  }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
