@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <div class="row heading">
            <div class="col-md-12">
                <h1>{{ $user->first_name . ' ' . $user->last_name }}</h1>
                <a href="{{ route('dashboard') }}" class="icon-text"><span class="glyphicon glyphicon-home"></span>Back to dashboard</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})">
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection