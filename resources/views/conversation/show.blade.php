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
                    <a href="{{ route('conversation.index') }}" class="icon-text"><span class="glyphicon glyphicon-th-list"></span>Back to conversations</a>
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