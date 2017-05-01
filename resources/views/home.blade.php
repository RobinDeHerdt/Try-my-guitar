@extends('layouts.app')

@section('content')
<div class="header-content">
    <h1>Try my guitar</h1>
    <div class="header-search">
        <form class="form-inline">
            <input type="text" class="form-control search-input" name="search-term" placeholder="Search for a guitar">
            <input type="submit" class="btn btn-default search-submit">
        </form>
    </div>
</div>
<div class="header-image" style="background-image: url('/images/electric-guitars.jpg');"></div>
<div class="container">
    <div class="row row-padding-top">
        <div class="col-md-12">
            <h1>Hello world!</h1>
        </div>
    </div>
</div>
@endsection
