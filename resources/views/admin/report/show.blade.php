@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection


@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>{{ $report->reported->fullName() }}</h1>
                    <a href="{{ route('admin.reports.index') }}" class="icon-text"><span class="glyphicon glyphicon-list"></span>Report overview</a>
                </div>
            </div>
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row col-container">
                <div class="col-md-12">
                    <h4>Reason (report sent by <a href="{{ route('profile.show', ['user' => $report->reporter->id]) }}">{{ $report->reporter->fullName() }}</a>)</h4>
                    <br>
                    <p>{{ $report->reason }}</p>
                </div>
            </div>
            <div class="row admin-footer">
                <div class="col-md-12 col-container">
                    <h3>Actions</h3>
                    <form action="{{ route('admin.reports.reviewed', ['report' => $report->id]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="radio-inline"><input type="radio" name="action" value="0">Don't take action at this time</label>
                            <label class="radio-inline"><input type="radio" name="action" value="1">Ban this user</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
