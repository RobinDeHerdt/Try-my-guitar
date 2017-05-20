@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content">
                        <h2>Brands</h2>
                        <div class="row">
                            @foreach($brands as $brand)
                                <div class="col-md-2">
                                    <a href="{{ route('brand.show', ['brand' => $brand->id]) }}">
                                        <div style="background-image:url({{  Storage::disk('public')->url($brand->logo_uri) }}" class="brand-logo"></div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content">
                        <h2>Categories</h2>
                        <div class="row">
                            @foreach($types as $type)
                                <div class="col-md-2 center">
                                    <a href="{{ route('type.show', ['brand' => $type->id]) }}">
                                        <div style="background-image:url({{  Storage::disk('public')->url($type->image_uri) }}" class="brand-logo"></div>
                                        <span>{{ $type->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
