@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content" id="chat-page">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>{{ $channel->name }}</h1>
                    <a href="{{ route('conversation.leave') }}" class="icon-text" onclick="event.preventDefault(); document.getElementById('leave-form').submit();"><span class="glyphicon glyphicon-log-out"></span>Leave this conversation</a>
                    <a href="{{ route('conversation.index') }}" class="icon-text"><span class="glyphicon glyphicon-th-list"></span>Back to conversations</a>
                    <a href="{{ route('conversation.update') }}" class="icon-text" onclick="event.preventDefault(); document.getElementById('edit-channel-form').style.display = 'inherit'"><span class="glyphicon glyphicon-pencil"></span>Edit conversation name</a>
                    <div class="row edit-channel-form">
                        <form id="edit-channel-form" action="{{ route('conversation.update') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                            <div class="col-md-10">
                                <input type="text" name="channel_name" class="form-control" placeholder="Enter a new channel name">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="document.getElementById('edit-channel-form').submit();" class="btn btn-primary">Save</button>
                                <div class="close-edit-form" onclick="document.getElementById('edit-channel-form').style.display = 'none'">
                                    Close <span class="glyphicon glyphicon-remove"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form id="leave-form" action="{{ route('conversation.leave') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                    </form>
                </div>
            </div>
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="chat-container">
                        <chat-messages :messages="messages"></chat-messages>
                    </div>
                    <div class="chat-form">
                        <chat-form v-on:messagesent="addMessage" :user="{{ Auth::user() }}"></chat-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection