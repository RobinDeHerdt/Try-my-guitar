@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="full-page-bg" style="background-image: url('/images/auth-bg.jpg')"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="authentication-block">
                    <div class="social">
                        <h4>Connect with</h4>
                        <ul>
                            <li><a href="/login/twitter" class="twitter"><span class="fa fa-twitter"></span></a></li>
                            <li><a href="/login/google" class="google"><span class="fa fa-google"></span></a></li>
                        </ul>
                    </div>
                    <div class="divider">
                        <span>or</span>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-6">
                                <label for="first_name">@lang('input.first-name') *</label>
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }} col-md-6">
                                <label for="last_name">@lang('input.last-name')</label>
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">@lang('input.email') *</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">
                                <label for="password">@lang('input.password') *</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password-confirm">@lang('input.confirm-password') *</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary big-cta-button">
                            @lang('input.register')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
