@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Find people</h2>
                    <div class="dashboard-content">
                        <div class="pac-card" id="pac-card">
                            <div id="pac-container">
                                <input id="pac-input" type="text" name="location" placeholder="Enter a location.">
                            </div>
                        </div>
                        <div id="map"></div>
                        <div id="infowindow-content">
                            <img src="" width="16" height="16" id="place-icon">
                            <span id="place-name"  class="title"></span><br>
                            <span id="place-address"></span>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="user-location" value="{{ $user_coords }}">
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
    <script>
        var markers = [];

        function initMap() {
            var user_locations_field    = document.getElementById('user-location');
            var user_location           = JSON.parse(user_locations_field.value);

            var card  = document.getElementById('pac-card');
            var input = document.getElementById('pac-input');

            var map = new google.maps.Map(document.getElementById('map'), {
                center: user_location,
                zoom: 3,
                minZoom: 5,
            });

            // Prevent the full form from submitting.
            input.onkeypress = function(e) {
                var key = e.charCode || e.keyCode || 0;
                if (key === 13) {
                    return false;
                }
            }

            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var infowindowContent = document.getElementById('infowindow-content');
            infowindow.setContent(infowindowContent);

            autocomplete.addListener('place_changed', function() {
                infowindow.close();

                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindowContent.children['place-icon'].src = place.icon;
                infowindowContent.children['place-name'].textContent = place.name;
                infowindowContent.children['place-address'].textContent = address;

                input.blur();
            });

            map.addListener('idle', function() {
                removeOutOfBoundsMarkers(map);
                addInBoundsMarkers(map);
            });
        }

        function removeOutOfBoundsMarkers(map) {
            for (var i = 0; i < markers.length; i++ ) {
                if(!map.getBounds().contains(markers[i].getPosition())) {
                    markers[i].setMap(null);
                    markers.splice(i, 1);
                }
            }
        }

        function addInBoundsMarkers(map) {
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
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACES_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
@endsection