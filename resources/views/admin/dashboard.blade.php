@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Control panel</h1>
                </div>
            </div>
            <div class="col-md-12 dashboard-content">
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
            <div class="col-md-12 dashboard-content">
                @if($contact_messages->isNotEmpty())
                    <h3>New contact messages</h3>
                    <hr>
                    @foreach($contact_messages as $contact_message)
                        <span><strong>From: </strong><a href="mailto:{{ $contact_message->email }}">{{ $contact_message->email }}</a></span><br>
                        <span><strong>Subject: </strong>{{ $contact_message->subject ? $contact_message->subject : 'No subject' }}</span><br>
                        <a href="{{ route('admin.messages.show', ['contact_message' => $contact_message->id]) }}">View</a>
                        <hr>
                    @endforeach
                @else
                    <span>There are no new contact messages.</span>
                @endif
                <a href="{{ route('admin.messages.index') }}">View all contact messages</a>
            </div>
        </div>
    </div>
@endsection