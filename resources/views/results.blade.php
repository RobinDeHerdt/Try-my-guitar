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
                            <h4>Categories</h4>
                            <div class="form-group">
                                <label class="radio-inline"><input type="radio" name="category" value="all" {{ $filter_category === 'all' || $filter_category === null ? 'checked' : '' }}>All</label>
                                <label class="radio-inline"><input type="radio" name="category" value="user" {{ $filter_category === 'user' ? 'checked' : '' }}>Users</label>
                                <label class="radio-inline"><input type="radio" name="category" value="guitar" {{ $filter_category === 'guitar' ? 'checked' : '' }}>Guitars</label>
                            </div>
                        </div>
                    </div>
                    <div id="guitar-filters" style="display: none">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Types</h4>
                            </div>
                            @foreach($types as $type)
                                <div class="col-md-2">
                                    <label class="checkbox-inline"><input type="checkbox" name="types[]" value="{{ $type->id }}" {{ in_array($type->id, $filter_types) ? 'checked' : ''}}>{{ $type->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Brands</h4>
                            </div>
                            @foreach($brands as $brand)
                                <div class="col-md-2">
                                    <label class="checkbox-inline"><input type="checkbox" name="brands[]" value="{{ $brand->id }}" {{ in_array($brand->id, $filter_brands) ? 'checked' : ''}}>{{ $brand->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="user-filters" style="display: none">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Location</h4>
                            </div>
                            <div class="col-md-2">
                                <label class="checkbox-inline"><input type="checkbox" name="proximity" {{ $filter_proximity ? 'checked' : ''}}>Sort by proximity</label>
                            </div>
                            <div class="col-md-2">
                                <label class="checkbox-inline"><input type="checkbox" id="range-toggle" {{ $filter_proximity_range ? 'checked' : ''}}>Filter range</label>
                            </div>
                            <div class="col-md-4">
                                <div id="range-slider">
                                    <span id="range-value"></span>
                                    <div id="proximity-slider"></div>
                                    <span id="range-min"></span>
                                    <input type="hidden" name="range" id="proximity-range" value="{{ $filter_proximity_range }}">
                                    <span id="range-max"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="search-results-search">
                            <div class="header-search">
                                <input type="text" class="form-control search-input" name="term" id="search-input" placeholder="Search for a user or guitar" value="{{app('request')->input('term') }}">
                                <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit" onclick="event.preventDefault(); document.getElementById('search-form').submit();">Search</a>
                                <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit-mobile" onclick="event.preventDefault(); document.getElementById('search-form').submit();"><i class="fa fa-search" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @if($most_relevant_users->isEmpty() && $less_relevant_users->isEmpty() && $most_relevant_guitars->isEmpty() && $less_relevant_guitars->isEmpty())
                <div class="no-results">
                    <h4>No results found.</h4>
                </div>
            @endif
            @if($most_relevant_guitars->isNotEmpty() || $less_relevant_guitars->isNotEmpty())
                <h2>Guitars</h2>
                <hr class="dark-hr">
                <div class="row">
                    <div class="col-md-12">
                        <span class="float-left">
                            <strong>
                                Showing
                                {{ $less_relevant_guitars->count() + $most_relevant_guitars->count() }}
                                of
                                {{ $guitars_count }}
                                {{ ($guitars_count > 1 ? 'total results' : 'result') }}
                            </strong>
                        </span>
                        @if($filter_category === 'all' || $filter_category === null)
                            @if(($less_relevant_guitars->count() + $most_relevant_guitars->count()) < $guitars_count)
                                <span class="float-right">
                                    <strong>
                                        <a href="/search" id="search-all-guitars">Show all results</a>
                                    </strong>
                                </span>
                            @endif
                        @endif
                        @if($less_relevant_guitars instanceof \Illuminate\Pagination\AbstractPaginator  && $less_relevant_guitars->total() > $less_relevant_guitars->perPage())
                            <span class="float-right"><strong>Page {{ $less_relevant_guitars->currentPage() }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    @if($most_relevant_guitars->isNotEmpty())
                        @foreach($most_relevant_guitars as $guitar)
                            <div class="col-md-12">
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
                    @endif
                    @if($less_relevant_guitars->isNotEmpty())
                        @foreach($less_relevant_guitars as $guitar)
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
                        <div class="col-md-12">
                            @if($less_relevant_guitars instanceof \Illuminate\Pagination\AbstractPaginator)
                                {{ $less_relevant_guitars->links() }}
                            @endif
                        </div>
                    @endif
                </div>
            @endif
            @if($most_relevant_users->isNotEmpty() || $less_relevant_users->isNotEmpty())
                <h2>Users</h2>
                <hr class="dark-hr">
                <div class="row">
                    <div class="col-md-12">
                        <span class="float-left">
                            <strong>
                                Showing
                                {{ $less_relevant_users->count() + $most_relevant_users->count() }}
                                of {{ $users_count }}
                                {{ ($users_count > 1 ? 'total results' : 'result') }}
                            </strong>
                        </span>
                        @if($filter_category === 'all' || $filter_category === null)
                            @if(($less_relevant_users->count() + $most_relevant_users->count()) < $users_count)
                                <span class="float-right">
                                    <strong>
                                        <a href="/search" id="search-all-users">Show all results</a>
                                    </strong>
                                </span>
                            @endif
                        @endif
                        @if($less_relevant_users instanceof \Illuminate\Pagination\AbstractPaginator && $less_relevant_users->total() >= $less_relevant_users->perPage())
                            <span class="float-right"><strong>Page {{ $less_relevant_users->currentPage() }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    @foreach($most_relevant_users as $user)
                        <div class="col-md-12">
                            <div class="search-result-header-image" style="background-image: url({{ Storage::disk('public')->url($user->header_image_uri) }})"></div>
                            <div class="search-result">
                                <a href="{{ route('profile.show', ['id' => $user->id]) }}">
                                    <div class="search-result-overlay">
                                        <span class="search-result-overlay-text">View profile</span>
                                    </div>
                                </a>
                                <div class="search-result-profile-image" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})"></div>
                                <h3>{{ $user->fullName()  }}</h3>
                                <span>&#177; {{ round($user->distance) }} km away</span>
                            </div>
                        </div>
                    @endforeach
                    @foreach($less_relevant_users as $user)
                        <div class="col-md-6">
                            <div class="search-result-header-image" style="background-image: url({{ Storage::disk('public')->url($user->header_image_uri) }})"></div>
                            <div class="search-result">
                                <a href="{{ route('profile.show', ['id' => $user->id]) }}">
                                    <div class="search-result-overlay">
                                        <span class="search-result-overlay-text">View profile</span>
                                    </div>
                                </a>
                                <div class="search-result-profile-image" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})"></div>
                                <h3>{{ $user->fullName()  }}</h3>
                                <span>&#177; {{ round($user->distance) }} km away</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12">
                    @if($less_relevant_users instanceof \Illuminate\Pagination\AbstractPaginator)
                        {{ $less_relevant_users->links() }}
                    @endif
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
        if(!getUrlParam('range')) {
            // Replace this by a hidden input field with the max distance value.
            $('#proximity-range').val(10000);
        }

        $( "#proximity-slider" ).slider({
            min: 1,
            max: 10000,
            value: $('#proximity-range').val(),
            create: function(event, ui) {
                $('#range-min').text($(this).slider("option", "min") + ' km');
                $('#range-value').text($(this).slider("option", "max") + ' km');
                $('#range-max').text($(this).slider("option", "max") + ' km');
            },
            change: function( event, ui ) {
                $('#proximity-range').val($(this).slider("value"));
                $('#range-value').text($(this).slider("value") + ' km');
            },
        });



        $( "#search-input" ).autocomplete({
            source: "{{ route('search.autocomplete') }}",
            minLength: 1,
            autoFocus:true,
            select: function (event, ui) {
                $('#search-input').val(ui.item.value);
                $('#search-form').submit();
            }
        });

        function getUrlParam(param) {
            var values = {};
            window.location.href.replace( location.hash, '' ).replace(
                /[?&]+([^=&]+)=?([^&]*)?/gi,
                function( m, key, value ) {
                    values[key] = value !== undefined ? value : '';
                }
            );

            if ( param ) {
                return values[param] ? values[param] : null;
            }
            return values;
        }

        showSpecificFilters(getUrlParam('category'));

        $( "#search-all-guitars" ).click(function(event) {
            event.preventDefault();

            $("input[name='category']").val("guitar");
            $("#search-form").submit();
        });

        $( "#search-all-users" ).click(function(event) {
            event.preventDefault();

            $("input[name='category']").val("user");
            $("#search-form").submit();
        });

        $("input[name=category]").change(function() {
            showSpecificFilters($("input[name='category']:checked").val());
        });

        $("#range-toggle").change(function() {
            showSpecificFilters($("input[name='category']:checked").val());
        });

        function showSpecificFilters(category) {
            switch(category)  {
                case 'user':
                    $("#guitar-filters").hide();
                    $("#user-filters").show();
                    $("input[name='types[]']:checkbox").prop("checked",false);
                    $("input[name='brands[]']:checkbox").prop("checked",false);
                    if($("#range-toggle").is(":checked")) {
                        $("#range-slider").show();
                        $("#proximity-range").prop("disabled", false);
                    } else {
                        $("#range-slider").hide();
                        $("#proximity-range").prop("disabled", true);
                    }

                    break;

                case 'guitar':
                    $("#user-filters").hide();
                    $("#guitar-filters").show();
                    $("input[name='proximity']:checkbox").prop("checked",false);
                    $("#proximity-range").prop("disabled", true);
                    $("#range-slider").hide();
                    $("#range-toggle").prop("checked",false);
                    $("#proximity-range").prop("disabled", true);
                    break;

                default:
                    $("#guitar-filters").hide();
                    $("#user-filters").hide();
                    $("input[name='types[]']:checkbox").prop("checked",false);
                    $("input[name='brands[]']:checkbox").prop("checked",false);
                    $("input[name='proximity']:checkbox").prop("checked",false);
                    $("#range-toggle").prop("checked",false);
                    $("#proximity-range").prop("disabled", true);
            }
        }
    </script>
    @include('partials.analytics')
@endsection
