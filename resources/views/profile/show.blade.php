@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="header-image profile-header-image" style="background-image: url({{ Storage::disk('public')->url($user->header_image_uri) }})"></div>
        <div class="container profile-container">
            <div class="profile-image" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})"></div>
            @if($user->verified)
            <span title="Verified e-mail address">
                <div class="verified-mark"><i class="fa fa-check fa-2x" aria-hidden="true"></i></div>
            </span>
            @endif
            <h1 class="profile-name">{{ $user->fullName() }}</h1>
            @if($user->description)
                <p class="text-center profile-description">{{ $user->description }}</p>
            @endif
            @if($user->location)
                <span class="profile-location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $user->location }}</span>
            @endif
            <div class="row">
                <div class="col-md-2 col-md-offset-5">
                    @if(Auth::check())
                        @if ($user->id === Auth::user()->id)
                            <div class="big-cta-button">
                                <a href="{{ route('profile.edit') }}">Edit profile</a>
                            </div>
                        @else
                            <div class="big-cta-button">
                                <a href="{{ route('profile.invite', ['id' => $user->id]) }}">Invite to chat</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection