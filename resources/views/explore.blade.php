@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Guitar brands</h2>
                    <div class="dashboard-content">
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
                    <h2>Guitar types</h2>
                    <div class="dashboard-content">
                        <div class="row">
                            @foreach($types as $type)
                                <div class="col-md-3 center explore-type-container">
                                    <div style="background-image:url({{  Storage::disk('public')->url($type->image_uri) }}" class="type-image"></div>
                                    <a href="{{ route('type.show', ['brand' => $type->id]) }}">
                                        <div class="guitar-type-button">
                                            <span>{{ $type->name }}</span>
                                        </div>
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
