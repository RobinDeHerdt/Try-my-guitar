@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Conversations</h2>
                <a href="{{ route('profile') }}">Back to profile</a>
                <div class="chats-overview">
                    @foreach($channels as $channel)
                        <div class="channel">
                            <div class="channel-name">
                                <a href="{{ route('channels.show', ['id' => $channel->id]) }}">{{ $channel->name }}</a>
                            </div>
                            <div class="channel-participants">
                                @foreach($channel->users as $user)
                                <div class="profile-teaser">
                                    <a href="#">
                                        <div class="profile-picture" style="background-image: url('/{{ $user->image_uri }}')"></div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
