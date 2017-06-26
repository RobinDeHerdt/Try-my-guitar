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
                <div class="col-md-5">
                    <div class="dashboard-content dashboard-min-height">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="center-content">
                                    <a href="{{ route('brand.show', ['brand' => str_slug($guitar->guitarBrand->name)]) }}">
                                        <img src="{{ Storage::disk('public')->url($guitar->guitarBrand->logo_uri) }}" alt="{{ $guitar->guitarBrand->name }} logo" class="guitar-brand-logo">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="center-content">
                            <h1>{{ $guitar->name }}</h1>
                            <div class="guitar-type-container">
                                @foreach($guitar->guitarTypes as $guitarType)
                                    <a href="{{ route('type.show', ['id' => str_slug($guitarType->name)])}}"><span class="guitar-type">{{ $guitarType->name }}</span></a>
                                @endforeach
                            </div>
                            <div class="guitar-description-container">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{ $guitar->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    @if(Auth::check())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dashboard-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @if(!Auth::user()->guitars->contains('id', $guitar->id))
                                                <div class="guitar-button-container">
                                                    <div class="guitar-button blue" title="Add this guitar to your collection"><i class="fa fa-plus" aria-hidden="true"></i></div>
                                                    <span>Do you own this guitar?</span>
                                                    <br>
                                                    <a href="{{ route('collection.store') }}" onclick="event.preventDefault(); document.getElementById('add-to-collection').submit();">
                                                        <span>Add to collection</span>
                                                    </a>
                                                </div>
                                                <form action="{{ route('collection.store') }}" method="POST" id="add-to-collection">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="guitar" value="{{ $guitar->id }}">
                                                </form>
                                            @else
                                                <div class="guitar-button-container">
                                                    <div class="guitar-button blue" title="Add this guitar to your collection"><i class="fa fa-check" aria-hidden="true"></i></div>
                                                    <span>This guitar is part of your collection!</span>
                                                    <br>
                                                    <a href="{{ route('collection.show', ['user' => Auth::user()->id]) . "#guitar-" . $guitar->id }}">View</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            @if(!Auth::user()->guitarExperience($guitar))
                                                <div class="guitar-button-container">
                                                    <div class="guitar-button blue" title="Share your experience with this guitar"><i class="fa fa-comment" aria-hidden="true"></i></div>
                                                    <span>Have you experienced this guitar?</span>
                                                    <br>
                                                    <a href="{{ route('experience.create', ['guitar' => $guitar]) }}">
                                                        <span>Share your experience</span>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="guitar-button-container">
                                                    <div class="guitar-button blue"><i class="fa fa-check" aria-hidden="true"></i></div>
                                                    <span>You have shared your experience!</span>
                                                    <br>
                                                    <a href="{{ route('guitar.show.experiences', ['guitar' => $guitar]) . '#experience-' . Auth::user()->guitarExperience($guitar)->id }}">
                                                        <span>View</span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            @if(Auth::user())
                                                <div class="guitar-button-container">
                                                    <div class="guitar-button blue" title="Add an image for this guitar"><i class="fa fa-image" aria-hidden="true"></i></div>
                                                    <span>Do you have an image of this guitar?</span>
                                                    <br>
                                                    <a href="{{ route('guitar.image.create', ['guitar' => $guitar]) }}">
                                                        <span>Upload images</span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12">
                            <div class="dashboard-content">
                                <div class="guitar-button-container">
                                    <span><a href="{{ route('login') }}">Log in </a> to add this guitar to your collection </span>
                                </div>
                            </div>
                        </div>
                    @endif
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="padding-top">Owners <span class="counter">{{ $guitar_user_count }}</span></h2>
                    <div class="col-container">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="user-location" value="{{ $user_coords }}">
            <input type="hidden" id="guitar-id" value="{{ $guitar->id }}">
            @if($guitar->experiences->isNotEmpty())
                <h2>Experiences <span class="counter">{{ $guitar->experiences->count() }}</span></h2>
                <div class="row">
                    @foreach($guitar->experiences as $experience)
                        <div class="col-md-6">
                            <div class="experience-container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="experience-user">
                                            <a href="{{ route('profile.show', ['user' => $experience->user->id]) }}" title="{{ $experience->user->fullName() }}">
                                                <div class="experience-user-image" style="background-image: url({{ Storage::disk('public')->url($experience->user->image_uri) }})"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="{{ route('guitar.show.experiences', ['guitar' => $guitar->id]) . "#experience-".$experience->id }}" title="View experience">
                                            <div class="experience-text">
                                                <p>{{ str_limit($experience->experience, 150) }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row"><div class="col-md-4 col-md-offset-4">
                        <div class="big-cta-button">
                            <a href="{{ route('guitar.show.experiences', $guitar->id) }}">View all experiences</a>
                        </div>
                    </div>
                </div>
            @endif
            @if($brand_guitars->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <h2>More {{ $guitar->guitarBrand->name }} guitars</h2>
                        <div class="dashboard-content">
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
                </div>
            @endif
            @if($similar_guitars->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <h2>Similar guitars</h2>
                        <div class="dashboard-content">
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
        var markers = [];

        function initMap() {
            var user_locations_field = document.getElementById('user-location');
            var user_location = JSON.parse(user_locations_field.value);

            var guitar_id = document.getElementById('guitar-id').value;

            var map = new google.maps.Map(document.getElementById('map'), {
                center: user_location,
                zoom: 5
            });

            var infowindow = new google.maps.InfoWindow();

            $.get('/guitar/'+ guitar_id +'/map').done(function( data ) {
                for (var i = 0; i < data.length; i++) {
                    var latLng = new google.maps.LatLng({lat: data[i].location_lat, lng: data[i].location_lng});
                    var marker = new google.maps.Marker({
                        map: map,
                        position: latLng,
                        user: data[i],
                    });

                    markers.push(marker);

                    marker.addListener('click', function() {
                        infowindow.close();
                        infowindow.setContent(
                            "<div class='center-content'>" +
                            "<a href='/profile/" + this.user.id + "'><img src='/storage/" + this.user.image_uri + "' width='100'>" +
                            "<br><br><strong>" + this.user.first_name + ' ' + this.user.last_name + "</strong></a>" +
                            "<br><span>" + this.user.location + "</span>" +
                            "</div>"
                        );
                        infowindow.open(map, this);
                    });
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACES_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script>
        $('.slick-main').slick({
            lazyLoad: 'ondemand',
            arrows: false,
            dots: true,
            variableWidth: true,
            centerMode: true,
            infinite: false,
        });

        $('.slick-related').slick({
            arrows: true,
            infinite: false,
            variableWidth: true,
            dots: true,
        });
    </script>
    @include('partials.analytics')
@endsection
