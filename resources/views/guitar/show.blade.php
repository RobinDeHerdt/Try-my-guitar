@extends('layouts.app')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css"/>
@endsection

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="dashboard-content">
                        <a href="{{ route('brand.show', ['brand' => $guitar->guitarBrand->id]) }}">
                            <img src="{{ Storage::disk('public')->url($guitar->guitarBrand->logo_uri) }}" alt="{{ $guitar->guitarBrand->name }} logo" class="guitar-brand-logo">
                        </a>
                        <h1>{{ $guitar->name }}</h1>
                        <div class="guitar-type-container">
                            @foreach($guitar->guitarTypes as $guitarType)
                                <a href="{{ route('type.show', ['id' => $guitarType->id]) }}"><span class="guitar-type">{{ $guitarType->name }}</span></a>
                            @endforeach
                        </div>
                        <div class="guitar-description-container">
                            {{ $guitar->description }}
                        </div>
                    </div>
                    <div class="dashboard-content">
                        <div class="slick-main">
                            @foreach($guitar->guitarImages as $guitarImage)
                                <div class="slick-item">
                                    <img src="{{ Storage::disk('public')->url($guitarImage->image_uri) }}">
                                    <span>By <a href="{{  route('profile.show', ['id' => $guitarImage->user->id]) }}"><strong>{{ $guitarImage->user->fullName() }}</strong></a></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if(!empty(json_decode($owner_locations)))
                    <div class="col-md-6">
                        <div class="dashboard-content">
                            <div id="map"></div>
                        </div>
                    </div>
                @endif
            </div>
            <input type="hidden" id="owner-locations" value="{{ $owner_locations }}">
            @if($owners->isNotEmpty())
                <h2>People that own this guitar</h2>
                <div class="row">
                    @foreach($owners as $user)
                        <div class="col-md-6">
                            <div class="experience-container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="experience-user">
                                            <a href="{{ route('profile.show', ['user' => $user->id]) }}" title="{{ $user->fullName() }}">
                                                <div class="experience-user-image" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="experience-text">
                                            <blockquote>
                                                <br>
                                                <p>{{ $user->pivot->experience }}</p>
                                                <span> - <strong>{{ $user->fullName() }}</strong></span>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($experiencers->isNotEmpty())
                <h2>People that have experienced this guitar</h2>
                <div class="row">
                    @foreach($experiencers as $user)
                        <div class="col-md-6">
                            <div class="experience-container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="experience-user">
                                            <a href="{{ route('profile.show', ['user' => $user->id]) }}" title="{{ $user->fullName() }}">
                                                <div class="experience-user-image" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="experience-text">
                                            <blockquote>
                                                <br>
                                                <p>{{ $user->pivot->experience }}</p>
                                                <span> - <strong>{{ $user->fullName() }}</strong></span>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($brand_guitars->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <h2>More {{ $guitar->guitarBrand->name }} guitars</h2>
                        <div class="slick-related">
                            @foreach($brand_guitars as $brand_guitar)
                                <a href="{{ route('guitar.show', ['guitar' => $brand_guitar->id]) }}">
                                <div class="slick-item">
                                    @if($brand_guitar->guitarImages->isNotEmpty())
                                        <img src="{{ Storage::disk('public')->url($brand_guitar->guitarImages->first()->image_uri) }}">
                                    @else
                                        <div class="search-result-image">No image available</div>
                                    @endif
                                    <span class="guitar-link">{{ $brand_guitar->name }}</span>
                                </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if($similar_guitars->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <h2>Similar guitars</h2>
                        <div class="slick-related">
                            @foreach($similar_guitars as $similar_guitar)
                                <a href="{{ route('guitar.show', ['guitar' => $similar_guitar->id]) }}">
                                    <div class="slick-item">
                                        @if($similar_guitar->guitarImages->isNotEmpty())
                                            <img src="{{ Storage::disk('public')->url($similar_guitar->guitarImages->first()->image_uri) }}">
                                        @else
                                            <div class="search-result-image">No image available</div>
                                        @endif
                                        <span class="guitar-link">{{ $similar_guitar->name }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
@section('scripts')
    @if(!empty(json_decode($owner_locations)))
        <script>
            function initMap() {
                var locations_field = document.getElementById('owner-locations');
                var locations = JSON.parse(locations_field.value);

                // @todo base this on geolocation
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: locations[0],
                    zoom: 5
                });

                if(locations) {
                    for (var i = 0; i < locations.length; i++) {
                        var marker = new google.maps.Marker({
                            map: map,
                            anchorPoint: new google.maps.Point(0, -29)
                        });
                        marker.setPosition(locations[i]);
                    }
                }
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACES_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
    @endif
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script>
        $('.slick-main').slick({
            lazyLoad: 'ondemand',
            infinite: true,
            arrows: false,
            dots: true,
            variableWidth: true,
            centerMode: true,
        });

        $('.slick-related').slick({
            arrows: true,
            infinite: false,
            variableWidth: true,
        });
    </script>
@endsection
