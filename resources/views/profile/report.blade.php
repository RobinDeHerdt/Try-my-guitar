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
                    <h1>@lang('content.report-fullname', ['fullname' => $user->fullName()])</h1>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-user"></span>@lang('content.view-name-profile', ['name' => $user->first_name])</a>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-user"></span></a>
                </div>
            </div>
            <div class="col-container">
                <form role="form" method="POST" action="{{ route('report.store', ['user' => $user->id]) }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('reason') ? ' has-error' : '' }}">
                                <label for="reason">@lang('input.reason')</label>
                                <textarea name="reason" cols="30" rows="5" class="form-control" placeholder="@lang('content.valid-reason')"></textarea>
                                @if ($errors->has('reason'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('reason') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control">@lang('input.send')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    @include('partials.analytics')
@endsection
