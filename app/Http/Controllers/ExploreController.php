<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuitarBrand;
use App\GuitarType;
use App\User;


class ExploreController extends Controller
{
    /**
     * Display the explore page.
     *
     * @return \Illuminate\Http\Response
     */
    public function explore()
    {
        $types  = GuitarType::all();
        $brands = GuitarBrand::all();

        $ip_address = request()->ip();
        $user_location = geoip($ip_address);
        $user_coords = ['lat' => $user_location->lat, 'lng' => $user_location->lon];

        $users_coords = User::all('location_lat','location_lng');

        $user_locations = [];

        foreach ($users_coords as $user) {
            array_push($user_locations, ['lat' => $user->location_lat, 'lng' => $user->location_lng]);
        }


        return view('explore', [
            'types'     => $types,
            'brands'    => $brands,
            'user_locations'   => json_encode($user_locations),
            'user_coords'       => json_encode($user_coords),
        ]);
    }
}
