@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <div class="row heading">
            <div class="col-md-12">
                <h1>Conversations</h1>
                <a href="{{ route('dashboard') }}" class="icon-text"><span class="glyphicon glyphicon-home"></span>Back to dashboard</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="chats-overview">
                    @foreach($channels as $channel)
                        <div class="channel">
                            <div class="channel-name">
                                <a href="{{ route('conversation.show', ['id' => $channel->id]) }}">{{ $channel->name }}</a>
                            </div>
                            <div class="channel-participants">
                                @foreach($channel->users as $user)
                                    <div class="profile-teaser">
                                        <a href="{{ route('profile.show', ['id' => $user->id]) }}" title="{{ $user->first_name . ' ' . $user->last_name }}">
                                            <div class="profile-picture" style="background-image: url('{{ Storage::disk('public')->url($user->image_uri) }}')"></div>
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
