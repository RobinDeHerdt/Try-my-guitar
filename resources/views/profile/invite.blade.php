@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Invite {{ $user->first_name }} to a conversation</h1>
                    <a href="{{ route('chat.index') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-list"></span>Conversation overview</a>
                    <a href="{{ route('chat.index') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-list"></span></a>
                    <a href="{{ route('dashboard') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-home"></span>Back to dashboard</a>
                    <a href="{{ route('dashboard') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-home"></span></a>
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
                                    <a href="{{ route('invite') }}" onclick="event.preventDefault(); document.getElementById('invite-form-{{ $channel->id }}').submit();"><i class="fa fa-user-plus" aria-hidden="true"></i>{{ $channel->name }}</a>
                                    <form id="invite-form-{{ $channel->id }}" action="{{ route('invite') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                                    </form>
                                </div>
                                <div class="channel-participants">
                                    @foreach($channel->users as $participant)
                                        <div class="profile-teaser {{ $participant->pivot->accepted ? '' : 'invited' }}">
                                            <a href="{{ route('profile.show', ['id' => $participant->id]) }}" title="{{ $participant->fullName() }}{{ $participant->pivot->accepted ? '' : ' - Invite pending' }}">
                                                <div class="profile-picture" style="background-image: url('{{ Storage::disk('public')->url($participant->image_uri) }}')"></div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="channel">
                            <div class="channel-name" id="create-channel-link">
                                <a href="{{ route('invite') }}" onclick="event.preventDefault(); showCreateChannelForm();"><i aria-hidden="true" class="fa fa-user-plus"></i>Create a new conversation</a>
                            </div>
                            <div class="channel-name" id="create-channel-container" style="display: none">
                                <form action="{{ route('invite') }}" method="POST" id="create-channel-form">
                                    {{ csrf_field() }}
                                    <i aria-hidden="true" class="fa fa-user-plus"></i>
                                    <input type="text" name="name" placeholder="Choose a channel name">
                                    <input type="submit" class="btn btn-primary" value="Save">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                </form>
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

@section('scripts')
    <script>
        function showCreateChannelForm() {
            $("#create-channel-link").hide();
            $("#create-channel-container").show();
        }
    </script>
@endsection