@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>{{ $cta_item->title }}</h1>
                    <a href="{{ route('admin.cta.index') }}" class="icon-text"><span class="glyphicon glyphicon-list"></span>Content items overview</a>
                </div>
            </div>
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <strong>EN Content</strong>
                    <p>{{ $cta_item->content_en }}</p>
                </div>
                <div class="col-md-6">
                    <strong>NL Content</strong>
                    <p>{{ $cta_item->content_nl }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection