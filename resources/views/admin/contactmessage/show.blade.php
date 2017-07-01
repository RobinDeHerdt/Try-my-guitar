@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Contact message</h1>
                    <a href="{{ route('admin.messages.index') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-list"></span>Back to overview</a>
                    <a href="{{ route('admin.messages.index') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-list"></span></a>
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
                    <h4>Subject: {{ $contact_message->subject ? $contact_message->subject : 'No subject' }}</h4>
                    <hr>
                    <p>{!! nl2br(e($contact_message->message)) !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection