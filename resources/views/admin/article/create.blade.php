@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row admin-heading">
            <div class="col-md-12">
                <h1>Create article</h1>
                <a href="{{ route('articles.index') }}" class="icon-text"><span class="glyphicon glyphicon-home"></span>Back to overview</a>
            </div>
        </div>
        @if (Session::has('success-message'))
            <div class="alert alert-success">{{ Session::get('success-message') }}</div>
        @endif
        @if (Session::has('info-message'))
            <div class="alert alert-info">{{ Session::get('info-message') }}</div>
        @endif
        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="body">Content</label>
                <textarea name="body" class="form-control" rows="8"></textarea>
            </div>
            <button type="submit" class="btn btn-default">Publish</button>
        </form>
    </div>
@endsection
