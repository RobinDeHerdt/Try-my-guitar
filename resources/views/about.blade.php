@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content {{ Auth::user() && Auth::user()->hasRole('administrator') ? 'admin-authenticated' : '' }}">
        <div class="container">
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            @if (Session::has('error-message'))
                <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
            @endif
            <h2>How does it work?</h2>
            <div class="row col-container">
                <div class="col-md-6">
                    <h3>Lorem ipsum</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.</p>
                </div>
                <div class="col-md-6">
                    <h3>Lorem ipsum</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
