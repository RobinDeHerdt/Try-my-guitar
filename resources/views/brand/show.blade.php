@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content brand-logo-header-container">
                        <img src="{{ Storage::disk('public')->url($brand->logo_uri) }}" alt="" class="brand-logo-header">
                    </div>
                </div>
            </div>
            <div class="dashboard-content search-filter">
                <h3>Filters</h3>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Types</h4>
                        <form action="{{ route('brand.show', ['brand' => $brand->name]) }}" method="GET">
                            <div class="row">
                                @foreach($types as $type)
                                    <div class="col-md-2">
                                        <label class="checkbox-inline"><input type="checkbox" name="types[]" value="{{ $type->id }}" {{ in_array($type->id, $filter_types) ? 'checked' : ''}}>{{ $type->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-9">
                                    <input type="submit" class="btn btn-primary big-cta-button" value="Filter">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if($guitars->isNotEmpty())
                <div class="row">
                    @foreach($guitars as $guitar)
                        <div class="col-md-6">
                            <div class="search-result">
                                <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}">
                                    <div class="search-result-overlay">
                                        <span class="search-result-overlay-text">View details</span>
                                    </div>
                                </a>
                                <img src="{{ Storage::disk('public')->url($guitar->guitarBrand->logo_uri) }}" alt="{{ $guitar->guitarBrand->name }} logo" class="search-result-logo">
                                @if($guitar->guitarImages->isNotEmpty())
                                    <img src="{{ Storage::disk('public')->url($guitar->guitarImages()->first()->image_uri) }}" class="search-result-image">
                                @else
                                    <div class="search-result-image">No image available</div>
                                @endif
                                <h3>{{ $guitar->name }}</h3>
                            </div>
                        </div>
                    @endforeach
                    {{ $guitars->links() }}
                </div>
            @else
                <div class="no-results">
                    <h4>No results found.</h4>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    @include('partials.analytics')
@endsection
