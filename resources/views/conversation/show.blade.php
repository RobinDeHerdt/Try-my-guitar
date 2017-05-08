@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container" id="chat-page">
        <div class="row heading">
            <div class="col-md-12">
                <h1>{{ $channel->name }}</h1>
                <a href="{{ route('conversation.index') }}" class="icon-text"><span class="glyphicon glyphicon-th-list"></span>Back to conversations</a>
            </div>
        </div>
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
@endsection

@section('footer')
    @include('partials.footer')
@endsection