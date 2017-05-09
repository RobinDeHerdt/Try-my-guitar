@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="profile-content">
                        <h3>Messages</h3>
                        <hr>
                        @if($messages->isNotEmpty())
                            @foreach($messages as $message)
                                <div class="message-teaser-container">
                                    <strong>{{ $message->channel->name }}</strong><br>
                                    <span>{{ $message->user->first_name }}: {{ $message->message }}</span><br>
                                    <a href="{{ route('conversation.show', [$message->channel_id]) }}">View  conversation</a>
                                </div>
                                <hr>
                            @endforeach
                        @else
                            <div class="message-teaser-container">
                                <span>There are no unseen messages.</span>
                            </div>
                        @endif
                        <a href="{{ route('conversation.index') }}">All conversations</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-content">
                        <h3>Collection</h3>
                        <hr>
                        <a href="#">View full collection</a><br>
                        <a href="#">Add to collection</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="profile-content">
                        <h3>Chat invitations</h3>
                        <hr>
                        @if($invitations->isNotEmpty())
                            @foreach($invitations as $invitation)
                                <div class="message-teaser-container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span>Invitation: </span><strong>{{ $invitation->name }}</strong>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <a href="{{ route('invite.response') }}" onclick="event.preventDefault(); document.getElementById('accept-form').submit();"><span><i class="fa fa-check" aria-hidden="true"></i> Accept</span></a>
                                            <form id="accept-form" action="{{ route('invite.response') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="response" value="1">
                                                <input type="hidden" name="channel" value="{{ $invitation->id }}">
                                            </form>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <a href="{{ route('invite.response') }}" onclick="event.preventDefault(); document.getElementById('decline-form').submit();"><span><i class="fa fa-times" aria-hidden="true"></i> Decline</span></a>
                                            <form id="decline-form" action="{{ route('invite.response') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="response" value="0">
                                                <input type="hidden" name="channel" value="{{ $invitation->id }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="message-teaser-container">
                                <span>There are no open invitations.</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-content">
                        <h3>Personal information</h3>
                        <hr>
                        <a href="{{ route('profile.edit') }}">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
