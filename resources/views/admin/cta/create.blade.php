@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @include('partials.messages')
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Create call to action</h1>
                    <a href="{{ route('admin.cta.index') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-list"></span>Back to overview</a>
                    <a href="{{ route('admin.cta.index') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-list"></span></a>
                </div>
            </div>
            <form action="{{ route('admin.cta.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Discover">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="title">Icon class</label>
                            <input type="text" name="icon_class" class="form-control" placeholder="fa-users">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="content_en">Content (EN)</label>
                                <textarea name="content_en" class="form-control" rows="4" placeholder="English content here"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="content_nl">Content (NL)</label>
                                <textarea name="content_nl" class="form-control" rows="4" placeholder="Nederlands content hier"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
