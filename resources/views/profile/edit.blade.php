@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Personal information</h1>
                    <a href="{{ route('dashboard') }}" class="icon-text"><span class="glyphicon glyphicon-home"></span>Back to dashboard</a>
                    <a href="{{ route('profile.show', ['id' => $user->id]) }}" class="icon-text"><span class="glyphicon glyphicon-user"></span>View profile</a>
                </div>
            </div>
            <div class="col-container">
                <form role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">@lang('input.first-name') *</label>
                                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">@lang('input.last-name')</label>
                                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">@lang('input.email') *</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="location">@lang('input.location')</label>
                                <input type="text" class="form-control" name="location" value="{{ $user->location }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Current picture</label>
                                <img src="{{ Storage::disk('public')->url($user->image_uri) }}" alt="profile picture" class="edit-profile-picture">
                            </div>
                            <div class="form-group">
                                <label for="image">Upload a new picture</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Profile appearance</h1>
                </div>
            </div>
            <div class="col-container">
                <form role="form" method="POST" action="{{ route('profile.appearance.update') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">@lang('input.description')</label>
                                <textarea name="description" cols="30" rows="5" class="form-control">{{ $user->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Current header image</label>
                                <img src="{{ Storage::disk('public')->url($user->header_image_uri) }}" alt="profile header image" class="edit-profile-picture">
                            </div>
                            <div class="form-group">
                                <label for="image">Upload a new header image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control">Save changes</button>
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