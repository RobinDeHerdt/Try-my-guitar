<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuitarBrand;
use App\GuitarType;
use App\User;

/**
 * Class ExploreController
 * @package App\Http\Controllers
 */
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

        $ip_address     = request()->ip();
        $user_location  = geoip($ip_address);
        $user_coords    = ['lat' => $user_location->lat, 'lng' => $user_location->lon];

        return view('explore', [
            'types'             => $types,
            'brands'            => $brands,
            'user_coords'       => json_encode($user_coords),
        ]);
    }

    /**
     * Get the marker locations for the current google maps viewport.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getLocations(Request $request)
    {
        $users = User::whereBetween('location_lat', [$request->query('lat1'), $request->query('lat0')])
            ->whereBetween('location_lng', [$request->query('lng1'), $request->query('lng0')])->get();

        return $users;
    }
}
