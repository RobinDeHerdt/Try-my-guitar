@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="profile-content">
                    <h3>Messages</h3>
                    @if($messages->isNotEmpty())
                        @foreach($messages as $message)
                            <div class="message-teaser-container">
                                <strong>{{ $message->channel->name }}</strong>
                                <p>{{ $message->user->first_name }}: {{ $message->message }}</p>
                                <a href="{{ route('conversation.show', [$message->channel_id]) }}">View  conversation</a>
                            </div>
                        @endforeach
                    @else
                        <div class="message-teaser-container">
                            <span>There are no unseen messages</span>
                        </div>
                    @endif
                    <a href="{{ route('conversation.index') }}">Go to conversations</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-content">
                    <h3>Collection</h3>
                    <a href="#">View full collection</a>
                    <a href="#">Add to collection</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="profile-content">
                    <h3>Personal information</h3>
                    <a href="{{ route('profile.edit') }}">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
