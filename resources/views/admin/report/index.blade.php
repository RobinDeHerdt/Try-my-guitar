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
                    <h1>Reports overview</h1>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-home"></span>Back to control panel</a>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-home"></span></a>
                </div>
            </div>
            @if($reports->isNotEmpty())
                <div class="table-responsive">
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
                                    <td class="center">{{ $report->reviewed ? 'yes' : 'no' }}</td>
                                    <td class="center">{{ $report->action ? $report->action : '' }}</td>
                                    <td class="center"><a href="{{ route('admin.reports.show', ['report' => $report->id]) }}"><span class="glyphicon glyphicon-search"></span></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $reports->links() }}
            @else
                <div class="no-results">
                    <h4>No reports to be displayed</h4>
                </div>
            @endif
        </div>
    </div>
@endsection
