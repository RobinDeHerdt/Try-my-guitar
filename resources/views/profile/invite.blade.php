@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="row heading">
                    <div class="col-md-12">
                        <h1>Invite {{ $user->first_name }} to a conversation</h1>
                        <a href="{{ route('dashboard') }}" class="icon-text"><span class="glyphicon glyphicon-home"></span>Back to dashboard</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="chats-overview">
                            @foreach($channels as $channel)
                                <div class="channel">
                                    <div class="channel-name">
                                        <a href="{{ route('conversation.invite') }}" onclick="event.preventDefault(); document.getElementById('invite-form-{{ $channel->id }}').submit();"><i class="fa fa-user-plus" aria-hidden="true"></i>{{ $channel->name }}</a>
                                        <form id="invite-form-{{ $channel->id }}" action="{{ route('conversation.invite') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
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
                            <div class="channel">
                                <div class="channel-name">
                                    <a href="{{ route('conversation.invite') }}" onclick="event.preventDefault(); document.getElementById('invite-form-create-new').submit();"><i class="fa fa-user-plus" aria-hidden="true"></i>{{ $channel->name }}</a>
                                    <form id="invite-form-create-new" action="{{ route('conversation.invite') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                                <div class="channel-participants">
                                    <div class="profile-teaser">
                                        <a href="{{ route('profile.show', ['id' => $user->id]) }}" title="{{ $user->first_name . ' ' . $user->last_name }}">

                                        </a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection