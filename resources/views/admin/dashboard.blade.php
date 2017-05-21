@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <h1>Control panel</h1>
            </div>
            <div class="row col-container">
                <div class="col-md-12">
                    @if($reports->isNotEmpty())
                        <h3>Reports to be reviewed</h3>
                        <hr>
                        @foreach($reports as $report)
                            <span>
                                <a href="{{ route('profile.show', ['user' => $report->reporter->id]) }}">{{ $report->reporter->fullName() }}</a>
                                has reported
                                <a href="{{ route('profile.show', ['user' => $report->reporter->id]) }}">{{ $report->reported->fullName() }}</a>:
                            </span>
                            <br>
                            <p>{{ $report->reason }}</p>
                            <a href="{{ route('admin.reports.show', ['report' => $report->id]) }}">View full report</a>
                            <hr>
                        @endforeach
                    @else
                        <span>There are no new contact messages.</span>
                    @endif
                    <a href="{{ route('admin.reports.index') }}">View all reports</a>
                </div>
            </div>
            <div class="row col-container">
                <div class="col-md-12">
                    @if($contact_messages->isNotEmpty())
                        <h3>New contact messages</h3>
                        <hr>
                        @foreach($contact_messages as $contact_message)
                            <span><strong>From: </strong><a href="mailto:{{ $contact_message->email }}">{{ $contact_message->email }}</a></span><br>
                            <span><strong>Message: </strong>{{ $contact_message->message }}</span><br><br>
                            <a href="{{ route('admin.messages.show', ['contact_message' => $contact_message->id]) }}">View full message</a>
                            <hr>
                        @endforeach
                    @else
                        <span>There are no new contact messages.</span>
                    @endif
                    <a href="{{ route('admin.messages.index') }}">View all contact messages</a>
                </div>
            </div>
        </div>
    </div>
@endsection