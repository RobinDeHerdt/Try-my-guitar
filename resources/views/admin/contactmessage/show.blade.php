@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Contact message</h1>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text"><span class="glyphicon glyphicon-home"></span>Back to control panel</a>
                    <a href="{{ route('admin.messages.index') }}" class="icon-text"><span class="glyphicon glyphicon-list"></span>Back to overview</a>
                </div>
            </div>
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('²success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <h4>Sender: <a href="mailto:{{ $contact_message->email }}">{{ $contact_message->email }}</a></h4>
                    <hr>
                    <p>{!! nl2br(e($contact_message->message)) !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection