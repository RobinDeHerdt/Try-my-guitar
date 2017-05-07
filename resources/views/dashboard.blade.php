@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 profile-content">
                <h3>Messages</h3>
                <span>Show latest conversations here</span><br>
                <a href="{{ route('conversation.index') }}">View all conversations</a>
            </div>
            <div class="col-md-6 profile-content">
                <h3>Collection</h3>
                <a href="#">View full collection</a>
                <a href="#">Add to collection</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3>Personal information</h3>
                <a href="{{ route('profile.edit') }}">Edit</a>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
