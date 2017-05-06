@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Profile</h1>
                @foreach($channels as $channel)
                    <a href="{{ route('channels.show', ['id' => $channel->id]) }}">{{ $channel->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
