@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content {{ Auth::user() && Auth::user()->hasRole('administrator') ? 'admin-authenticated' : '' }}">
        <div class="header-image" style="background-image: url('/images/login-bg.jpg');"></div>
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
            @foreach($about_sections as $about_section)
                    <h2>{{ $about_section->title }}</h2>
                <div class="row col-container" id="{{ strtolower(kebab_case($about_section->title)) }}">
                    <div class="col-md-6">
                        <p>{{ $about_section->column_one }}</p>
                    </div>
                    <div class="col-md-6">
                        <p>{{ $about_section->column_two }}</p>
                    </div>
                </div>
            @endforeach
            <div class="row col-container">
                <h2>Contact</h2>
                <form action="{{ route('contact') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="col-md-8 col-md-offset-2">
                        <div class="form-group">
                            <label for="email">@lang('input.email') *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">@lang('input.your-message') *</label>
                            <textarea name="message" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-8">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary form-control" value="Send">
                                </div>
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