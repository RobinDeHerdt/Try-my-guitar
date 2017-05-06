@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="profile-nav">
                    <ul>
                        <li><a href="{{ route('profile') }}">Personal info</a></li>
                        <li><a href="#">My collection</a></li>
                        <li><a href="{{ route('messages') }}">Messages</a></li>
                    </ul>
                </nav>
                <div class="chats-overview">
                    @foreach($channels as $channel)
                        <div class="channel">
                            <div class="channel-name">
                                <a href="{{ route('channels.show', ['id' => $channel->id]) }}">{{ $channel->name }}</a>
                            </div>
                            <div class="channel-participants">
                                @foreach($channel->users as $user)
                                <div class="profile-teaser">
                                    <div class="profile-picture" style="background-image: url('/{{ $user->image_uri }}')"></div>
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
