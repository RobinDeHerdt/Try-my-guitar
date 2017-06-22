@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Edit article</h1>
                    <a href="{{ route('articles.index') }}" class="icon-text"><span class="glyphicon glyphicon-home"></span>Back to overview</a>
                </div>
            </div>
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('articles.update', ['id' => $article->id]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $article->title }}">
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <select class="form-control" name="language">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <option value="{{ $article->lang ? $article->lang : $localeCode }}">{{ $properties['native'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="image">Replace image (if nothing is selected the current image will stay)</label>
                                    <input type="file" name="image" class="form-control" value="{{ $article->image_uri }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="body">Content</label>
                            <textarea name="body" class="form-control" rows="8">{{ $article->body }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Publish</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <label>Current image:</label>
                    <div style="background-image: url({{ Storage::disk('public')->url($article->image_uri) }})" class="admin-image"></div>
                </div>

            </div>
        </div>
    </div>
@endsection
