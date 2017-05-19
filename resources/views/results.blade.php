@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <form class="form-inline" id="search-form" method="GET" action="{{ route('search') }}">
                <div class="dashboard-content search-filter">
                    <h3>Filters</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Types</h4>
                            <div class="form-group">
                                @foreach($types as $type)
                                    <label class="checkbox-inline"><input type="checkbox" name="types[]" value="{{ $type->id }}" {{ in_array($type->id, $filter_types) ? 'checked' : ''}}>{{ $type->name }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>Categories</h4>
                            <div class="form-group">
                                <label class="checkbox-inline"><input type="checkbox" value="">Users</label>
                                <label class="checkbox-inline"><input type="checkbox" value="">Guitars</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Brands</h4>
                            <div class="form-group">
                                @foreach($brands as $brand)
                                    <label class="checkbox-inline"><input type="checkbox" name="brands[]" value="{{ $brand->id }}" {{ in_array($brand->id, $filter_brands) ? 'checked' : ''}}>{{ $brand->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search-results-search">
                    <div class="header-search">
                        <input type="text" class="form-control search-input" name="term" id="search-input" placeholder="Search for a user or guitar" value="{{app('request')->input('term') }}">
                        <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit" onclick="event.preventDefault(); document.getElementById('search-form').submit();">Search</a>
                        <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit-mobile" onclick="event.preventDefault(); document.getElementById('search-form').submit();"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                </div>
            </form>
            @if($users->isEmpty() && $guitars->isEmpty())
                <div class="no-results">
                    <h4>No results found.</h4>
                </div>
            @endif
            @if($users->isNotEmpty())
                <h2>Users</h2>
                <hr class="dark-hr">
                <div class="row">
                    @foreach($users as $user)
                        <div class="col-md-6">
                            <div class="search-result-header-image" style="background-image: url({{ Storage::disk('public')->url($user->header_image_uri) }})"></div>
                            <div class="search-result">
                                <a href="{{ route('profile.show', ['id' => $user->id]) }}">
                                <div class="search-result-overlay">
                                    <span class="search-result-overlay-text">View profile</span>
                                </div>
                                </a>
                                <div class="search-result-image" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})"></div>
                                <h3>{{ $user->fullName()  }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($guitars->isNotEmpty())
                <h2>Guitars</h2>
                <hr class="dark-hr">
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
                                    <div class="search-result-image" style="background-image: url({{ Storage::disk('public')->url($guitar->guitarImages()->first()->image_uri) }})"></div>
                                @else
                                    <div class="search-result-image">No image available</div>
                                @endif
                                <h3>{{ $guitar->name }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    <script>
        $( "#search-input" ).autocomplete({
            source: "{{ route('search.autocomplete') }}",
            minLength: 1,
            autoFocus:true,
            select: function (event, ui) {
                $('#search-input').val(ui.item.value);
                $('#search-form').submit();
            }
        });
    </script>
@endsection
