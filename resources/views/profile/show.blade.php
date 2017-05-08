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
                <div class="col-md-2 col-md-offset-2">
                    <div class="big-cta-button">
                        <a href="#">Invite to chat</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="big-cta-button">
                        <a href="#">Invite to group chat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection