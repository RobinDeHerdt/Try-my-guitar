@extends('layouts.app')

@section('content')
<div class="header-content">
    <h1>Try my guitar</h1>
    <div class="header-search">
        <form class="form-inline">
            <input type="text" class="form-control search-input" name="search-term" placeholder="Search for a guitar">
            <input type="submit" class="btn btn-default search-submit" value="Search">
        </form>
    </div>
</div>
<div class="header-image" style="background-image: url('/images/electric-guitars.jpg');"></div>
<div class="container">
    <div class="row row-padding-top">
        <h2>How does it work?</h2>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="cta-item">
                <i class="fa fa-music fa-4x" aria-hidden="true"></i>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae consectetur ex. Donec non sollicitudin erat. Aenean libero massa, lobortis eu consequat non, sollicitudin nec diam</p>
                <a href="#">Read more</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="cta-item">
                <i class="fa fa-music fa-4x" aria-hidden="true"></i>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae consectetur ex. Donec non sollicitudin erat. Aenean libero massa, lobortis eu consequat non, sollicitudin nec diam</p>
                <a href="#">Read more</a>
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="cta-item">
                <i class="fa fa-music fa-4x" aria-hidden="true"></i>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae consectetur ex. Donec non sollicitudin erat. Aenean libero massa, lobortis eu consequat non, sollicitudin nec diam</p>
                <a href="#">Read more</a>
            </div>
        </div>
    </div>
    <div class="row row-padding-top">
        <h2>Articles</h2>
    </div>
</div>
@endsection
