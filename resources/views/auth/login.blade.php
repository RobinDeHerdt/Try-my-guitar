@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="full-page-bg" style="background-image: url('/images/auth-bg.jpg')"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="authentication-block">
                    @if (session('info-message'))
                        <div class="alert alert-info">
                            {{ session('info-message') }}
                        </div>
                    @endif
                    <div class="social">
                        <h4>Connect with</h4>
                        <ul>
                            <li><a href="/login/facebook" class="facebook"><span class="fa fa-facebook"></span></a></li>
                            <li><a href="/login/twitter" class="twitter"><span class="fa fa-twitter"></span></a></li>
                            <li><a href="/login/google" class="google"><span class="fa fa-google"></span></a></li>
                        </ul>
                    </div>
                    <div class="divider">
                        <span>or</span>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">@lang('input.email')</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">@lang('input.password')</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>@lang('input.remember-me')
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary big-cta-button">
                                @lang('input.login')
                            </button>
                        </div>
                        <a href="{{ route('password.request') }}">@lang('input.forgot-password')</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
