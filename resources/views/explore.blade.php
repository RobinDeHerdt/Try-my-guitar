@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(!empty(json_decode($user_locations)))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dashboard-content">
                                    <div id="map"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <input type="hidden" id="owner-locations" value="{{ $user_locations }}">
                    <input type="hidden" id="user-location" value="{{ $user_coords }}">
                </div>
            </div>
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
                                <div class="col-md-3 center explore-guitar-type-container">
                                    <a href="{{ route('type.show', ['brand' => $type->id]) }}">
                                        <div style="background-image:url({{  Storage::disk('public')->url($type->image_uri) }}" class="type-image"></div>
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

@section('scripts')
    @if(!empty(json_decode($user_locations)))
        <script>
            var markers = [];

            function initMap() {
                var locations_field = document.getElementById('owner-locations');
                var user_locations_field = document.getElementById('user-location');

                var locations = JSON.parse(locations_field.value);
                var user_location = JSON.parse(user_locations_field.value);

                var map = new google.maps.Map(document.getElementById('map'), {
                    center: user_location,
                    zoom: 3,
                    minZoom: 5,
                });

                map.addListener('idle', function() {
                    removeMarkers(map);

                    var bounds = map.getBounds();

                    var lat0 = bounds.getNorthEast().lat();
                    var lng0 = bounds.getNorthEast().lng();
                    var lat1 = bounds.getSouthWest().lat();
                    var lng1 = bounds.getSouthWest().lng();

                    $.get("/explore/map", {
                        'lat0': lat0,
                        'lat1': lat1,
                        'lng0': lng0,
                        'lng1': lng1,
                    }).done(function( data ) {
                        for (var i = 0; i < data.length; i++) {
                            var latLng = new google.maps.LatLng({lat: data[i].location_lat, lng: data[i].location_lng});
                            var marker = new google.maps.Marker({
                                map: map,
                                position: latLng,
                            });

                            markers.push(marker);
                        }
                    });
                });
            }

            function removeMarkers(map) {
                for (var i = 0; i < markers.length; i++ ) {
                    if(!map.getBounds().contains(markers[i].getPosition())) {
                        markers[i].setMap(null);
                        markers.splice(i, 1);
                    }
                }
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACES_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
    @endif
@endsection