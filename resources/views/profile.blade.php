@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Active chats:</h1>
                <div class="chats-overview">
                @foreach($channels as $channel)
                    <div class="channel">
                        <div class="channel-name">
                            <a href="{{ route('channels.show', ['id' => $channel->id]) }}">{{ $channel->name }}</a>
                        </div>
                        <div class="channel-participants">
                            @foreach($channel->users as $user)
                            <div class="profile-teaser">
                                <div class="profile-picture" style="background-image: url('/{{ $user->image_uri }}')"></div>
                                {{--<span>{{ $user->first_name }}</span>--}}
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                </div>

                <h1>Personal data</h1>
                <form role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">@lang('input.name')</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">@lang('input.email')</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>
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
