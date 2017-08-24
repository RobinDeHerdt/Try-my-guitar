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
                    <h1>Users</h1>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-home"></span>Back to control panel</a>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-home"></span></a>
                </div>
            </div>
            @if($users->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="center">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name ? $user->last_name : 'n/a' }}</td>
                                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                    <td>{{ $user->active ? 'Active' : ($user->inactive_until ? 'Temporarily banned until ' . $user->inactive_until : 'Permanently banned') }}</td>
                                    <td class="center"><a href="{{ route('profile.show', ['id' => $user->id]) }}"><span class="glyphicon glyphicon-search"></span></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            @else
                <div class="no-results">
                    <h4>No users to be displayed</h4>
                </div>
            @endif
        </div>
    </div>
@endsection
