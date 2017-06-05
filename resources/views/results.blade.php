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
                                <h4>User filters here</h4>
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
                        <span>Showing {{ $less_relevant_guitars->count() + $most_relevant_guitars->count() }} of {{ $guitars_count }} {{ ($guitars_count > 1 ? 'total results' : 'result') }}</span>
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
                        @if($less_relevant_guitars instanceof \Illuminate\Pagination\AbstractPaginator)
                            {{ $less_relevant_guitars->links() }}
                        @endif
                    @endif
                </div>
            @endif
            @if($most_relevant_users->isNotEmpty() || $less_relevant_users->isNotEmpty())
                <h2>Users</h2>
                <hr class="dark-hr">
                <div class="row">
                    <div class="col-md-12">
                        <span>Showing {{ $less_relevant_users->count() + $most_relevant_users->count() }} of {{ $users_count }} {{ ($users_count > 1 ? 'total results' : 'result') }}</span>
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
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($less_relevant_users instanceof \Illuminate\Pagination\AbstractPaginator)
                    {{ $less_relevant_users->links() }}
                @endif
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

        $("input[name=category]").change(function() {
            showSpecificFilters($("input[name='category']:checked").val());
        });

        function showSpecificFilters(category) {
            switch(category)  {
                case 'user':
                    $("#guitar-filters").hide();
                    $("#user-filters").show();
                    $("input[name='types[]']:checkbox").prop('checked',false);
                    $("input[name='brands[]']:checkbox").prop('checked',false);
                    break;

                case 'guitar':
                    $("#user-filters").hide();
                    $("#guitar-filters").show();
                    break;

                default:
                    $("#guitar-filters").hide();
                    $("#user-filters").hide();
                    $("input[name=types]:checkbox").prop('checked',false);
            }
        }
    </script>
    @include('partials.analytics')
@endsection
