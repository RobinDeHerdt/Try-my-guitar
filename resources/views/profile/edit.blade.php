@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @include('partials.messages')
            <div class="row heading">
                <div class="col-md-12">
                    <h1>@lang('content.personal-info')</h1>
                    <a href="{{ route('dashboard') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-home"></span>@lang('content.back-to-dashboard')</a>
                    <a href="{{ route('dashboard') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-home"></span></a>
                    <a href="{{ route('profile.show', ['id' => $user->id]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-user"></span>@lang('content.view-profile')</a>
                    <a href="{{ route('profile.show', ['id' => $user->id]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-user"></span></a>
                </div>
            </div>
            <div class="col-container">
                <form role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name">@lang('input.first-name') *</label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}" required>
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name">@lang('input.last-name')</label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">@lang('input.email') * </label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">@lang('input.your-current-picture')</label>
                                <img src="{{ Storage::disk('public')->url($user->image_uri) }}" alt="profile picture" class="edit-profile-picture">
                            </div>
                            <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image">@lang('input.upload-new-picture')</label>
                                <input type="file" name="image" class="form-control">
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('content.preferred-spot')</label>
                                <div class="pac-card" id="pac-card">
                                    <div id="pac-container">
                                        <input id="pac-input" type="text" name="location" placeholder="@lang('content.where-meetup')" value="{{ old('location') ? old('location') : $user->location }}" onchange="inputChanged();">
                                    </div>
                                </div>
                                <div id="map"></div>
                                <div id="infowindow-content">
                                    <img src="" width="16" height="16" id="place-icon">
                                    <span id="place-name"  class="title"></span><br>
                                    <span id="place-address"></span>
                                </div>
                                <input type="hidden" class="form-control" name="location_lat" id="location-lat" value="{{ old('location_lat') ? old('location_lat') : $user->location_lat }}">
                                <input type="hidden" class="form-control" name="location_lng" id="location-lng" value="{{ old('location_lng') ? old('location_lng') : $user->location_lng }}">
                                <input type="hidden" class="form-control" id="user-coords" value="{{ $user_coords }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control">@lang('input.save-changes')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row heading">
                <div class="col-md-12">
                    <h1>@lang('content.profile-appearance')</h1>
                </div>
            </div>
            <div class="col-container">
                <form role="form" method="POST" action="{{ route('profile.appearance.update') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">@lang('input.description')</label>
                                <textarea name="description" cols="30" rows="5" class="form-control">{{ $user->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('input.current-header-image')</label>
                                <img src="{{ Storage::disk('public')->url($user->header_image_uri) }}" alt="profile header image" class="edit-profile-picture">
                            </div>
                            <div class="form-group">
                                <label for="image">@lang('input.upload-new-header-image')</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control">@lang('input.save-changes')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    <script>
        var input           = document.getElementById('pac-input');
        var card            = document.getElementById('pac-card');
        var location_lat    = document.getElementById('location-lat');
        var location_lng    = document.getElementById('location-lng');
        var user_coords     = document.getElementById('user-coords');

        function inputChanged() {
            if(!input.value) {
                location_lat.value = "";
                location_lng.value = "";
            }
        }

        function initMap() {
            if(location_lat.value && location_lng.value) {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: parseFloat(location_lat.value), lng: parseFloat(location_lng.value)},
                    zoom: 17
                });
            } else {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: JSON.parse(user_coords.value),
                    zoom: 7
                });
            }

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

            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            if(location_lat.value && location_lng.value) {
                marker.setPosition({lat: parseFloat(location_lat.value), lng: parseFloat(location_lng.value)});
            }

            autocomplete.addListener('place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                location_lat.value = place.geometry.location.lat();
                location_lng.value = place.geometry.location.lng();

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
                infowindow.open(map, marker);

                input.blur();
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACES_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
    @include('partials.analytics')
@endsection