@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="search-results-search">
                @include('partials.search')
            </div>
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
