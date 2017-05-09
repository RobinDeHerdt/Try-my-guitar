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
                        @if (Session::has('success-message'))
                            <div class="alert alert-success">{{ Session::get('success-message') }}</div>
                        @endif
                        @if (Session::has('info-message'))
                            <div class="alert alert-info">{{ Session::get('info-message') }}</div>
                        @endif
                        <div class="chats-overview">
                            @foreach($channels as $channel)
                                <div class="channel">
                                    <div class="channel-name">
                                        <a href="{{ route('conversation.invite') }}" onclick="event.preventDefault(); document.getElementById('invite-form-{{ $channel->id }}').submit();"><i class="fa fa-user-plus" aria-hidden="true"></i>{{ $channel->name }}</a>
                                        <form id="invite-form-{{ $channel->id }}" action="{{ route('conversation.invite') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                                        </form>
                                    </div>
                                    <div class="channel-participants">
                                        @foreach($channel->users as $user)
                                            <div class="profile-teaser {{ $user->pivot->accepted ? '' : 'invited' }}">
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
                                    <a href="{{ route('conversation.invite') }}" onclick="event.preventDefault(); document.getElementById('invite-form-create-new').submit();"><i class="fa fa-user-plus" aria-hidden="true"></i>Create new chat</a>
                                    <form id="invite-form-create-new" action="{{ route('conversation.invite') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    </form>
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