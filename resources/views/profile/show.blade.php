@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="header-image profile-header-image" style="background-image: url('/images/electric-guitars.jpg');"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 profile-image" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})"></div>
                <div class="col-md-3">
                    <h1 class="profile-name">{{ $user->first_name . ' ' . $user->last_name }}</h1>
                </div>
                <div class="col-md-2 col-md-offset-4">
                @if ($user->id !== Auth::user()->id)
                    <div class="big-cta-button">
                        <a href="{{ route('profile.invite', ['id' => $user->id]) }}">Invite to chat</a>
                    </div>
                @else
                    <div class="big-cta-button">
                        <a href="{{ route('profile.edit') }}">Edit profile</a>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection