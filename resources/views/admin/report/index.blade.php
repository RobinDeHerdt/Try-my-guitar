@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Reports overview</h1>
                </div>
            </div>
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            @if($reports->isNotEmpty())
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Reporter</th>
                        <th>Reported user</th>
                        <th>Reason</th>
                        <th>Date</th>
                        <th class="center">Reviewed</th>
                        <th class="center">Action taken</th>
                        <th class="center">View</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->reporter->fullName() }}</td>
                                <td>{{ $report->reported->fullName() }}</td>
                                <td>{{ str_limit($report->reason, 50) }}</td>
                                <td>{{ $report->created_at }}</td>
                                <td class="center">{{ $report->reviewed ? 'Yes' : 'No' }}</td>
                                <td class="center">{{ $report->action ? $report->action : '' }}</td>
                                <td class="center"><a href="{{ route('admin.reports.show', ['report' => $report->id]) }}"><span class="glyphicon glyphicon-search"></span></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $reports->links() }}
            @else
                <div class="no-results">
                    <h4>No reports to be displayed</h4>
                </div>
            @endif
        </div>
    </div>
@endsection
