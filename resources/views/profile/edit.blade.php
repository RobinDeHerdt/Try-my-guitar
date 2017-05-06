@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit profile</h1>
            <a href="{{ route('profile') }}">Back to profile</a>
            <form role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
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
                    </div>
                    <div class="col-md-4">
                        <img src="/{{ $user->image_uri }}" alt="profile picture" class="edit-profile-picture">
                        <div class="form-group">
                            <label for="image">Picture</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection