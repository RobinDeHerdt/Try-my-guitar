@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @include('partials.messages')
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Control panel</h1>
                </div>
            </div>
            <div class="col-md-12 dashboard-content">
                <h3>Reports to be reviewed</h3>
                <hr>
                @if($reports->isNotEmpty())
                    @foreach($reports as $report)
                        <span>
                            <a href="{{ route('profile.show', ['user' => $report->reporter->id]) }}">{{ $report->reporter->fullName() }}</a>
                            has reported
                            <a href="{{ route('profile.show', ['user' => $report->reporter->id]) }}">{{ $report->reported->fullName() }}</a>
                        </span>
                        &middot; <a href="{{ route('admin.reports.show', ['report' => $report->id]) }}">View report</a>
                        <hr>
                    @endforeach
                @else
                    <span>There are no new reports.</span>
                @endif
                <a href="{{ route('admin.reports.index') }}">View all reports</a>
            </div>
            <div class="col-md-12 dashboard-content">
                <h3>New contact messages</h3>
                <hr>
                @if($contact_messages->isNotEmpty())
                    @foreach($contact_messages as $contact_message)
                        <span><a href="mailto:{{ $contact_message->email }}">{{ $contact_message->email }}:</a> </span>
                        <span>{{ $contact_message->subject ? $contact_message->subject : 'No subject' }}</span> &middot;
                        <a href="{{ route('admin.messages.show', ['contact_message' => $contact_message->id]) }}">View</a><br>
                    @endforeach
                @else
                    <span>There are no new contact messages.</span>
                @endif
                <hr>
                <a href="{{ route('admin.messages.index') }}">View all contact messages</a>
            </div>
            <div class="col-md-12 dashboard-content">
                <h3>Newest Users</h3>
                <hr>
                @if($users->isNotEmpty())
                    @foreach($users as $user)
                        <a href="{{ route('profile.show', ['user' => $user->id]) }}">{{ $user->fullName() }}</a><span> ({{ $user->created_at->diffForHumans() }})</span><br>
                    @endforeach
                @else
                    <span>There are no new users.</span>
                @endif
                <hr>
                <a href="{{ route('admin.users.index') }}">View all users</a>
            </div>
            <div class="col-md-12 dashboard-content">
                <h3>Latest guitar contributions</h3>
                <hr>
                @if($guitars->isNotEmpty())
                    @foreach($guitars as $guitar)
                        <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}">{{ $guitar->name }}</a>
                        <span>({{ $guitar->created_at->diffForHumans() }} by <a href="{{ route('profile.show', ['id' => $guitar->contributor->id]) }}">{{ $guitar->contributor->fullName() }})</a></span><br>
                    @endforeach
                @else
                    <span>There are no new guitars.</span>
                @endif
                <hr>
                <a href="{{ route('admin.guitars.index') }}">View all guitars</a>
            </div>
            <div class="col-md-12 dashboard-content">
                <h3>Latest image contributions</h3>
                <hr>
                @if($guitarimages->isNotEmpty())
                    @foreach($guitarimages as $guitarimage)
                        <a href="{{ Storage::disk('public')->url($guitarimage->image_uri) }}">{{ $guitarimage->guitar->name }}</a>
                        <span>({{ $guitarimage->created_at->diffForHumans() }} by <a href="{{ route('profile.show', ['id' => $guitarimage->user->id]) }}">{{ $guitarimage->user->fullName() }})</a></span><br>
                    @endforeach
                @else
                    <span>There are no new images.</span>
                @endif
                <hr>
                <a href="{{ route('admin.guitarimages.index') }}">View all images</a>
            </div>
        </div>
    </div>
@endsection
