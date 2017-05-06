@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="profile-nav">
                    <ul>
                        <li class="profile-nav-selected"><a href="{{ route('profile') }}">Personal info</a></li>
                        <li><a href="#">My collection</a></li>
                        <li><a href="{{ route('messages') }}">Messages</a></li>
                    </ul>
                </nav>

                <h1>Personal data</h1>
                <form role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="first_name">@lang('input.first-name')</label>
                        <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">@lang('input.last-name')</label>
                        <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('input.email')</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>
                    <img src="/{{ $user->image_uri }}">
                    <div class="form-group">
                        <label for="image">Picture</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
