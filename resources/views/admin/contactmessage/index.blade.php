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
                    <h1>Messages</h1>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-home"></span>Back to control panel</a>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-home"></span></a>
                </div>
            </div>
            @if($contact_messages->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Sender</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th class="center">Date</th>
                            <th class="center">View</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contact_messages as $contact_message)
                            <tr>
                                <td><a href="mailto:{{ $contact_message->email }}">{{ $contact_message->email }}</a></td>
                                <td>{{ $contact_message->subject ? str_limit($contact_message->message, 75) : 'n/a' }}</td>
                                <td>{{ str_limit($contact_message->message, 75) }}</td>
                                <td class="center">{{ $contact_message->created_at }}</td>
                                <td class="center"><a href="{{ route('admin.messages.show', ['id' => $contact_message->id]) }}"><span class="glyphicon glyphicon-search"></span></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $contact_messages->links() }}
            @else
                <div class="no-results">
                    <h4>No contact messages to be displayed</h4>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
