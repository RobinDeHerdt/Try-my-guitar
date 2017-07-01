@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Update call to action</h1>
                    <a href="{{ route('admin.cta.index') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-list"></span>Back to overview</a>
                    <a href="{{ route('admin.cta.index') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-list"></span></a>
                </div>
            </div>
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <form action="{{ route('admin.cta.update', ['cta_item' => $cta_item]) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $cta_item->title }}" placeholder="Discover">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="title">Icon class</label>
                            <input type="text" name="icon_class" class="form-control" value="{{ $cta_item->icon_class }}" placeholder="fa-users">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="content_en">Content (EN)</label>
                                <textarea name="content_en" class="form-control" rows="4">{{ $cta_item->content_en }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="content_nl">Content (NL)</label>
                                <textarea name="content_nl" class="form-control" rows="4">{{ $cta_item->content_nl }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
