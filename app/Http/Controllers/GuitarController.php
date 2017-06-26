<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuitarImage;
use App\Guitar;
use Auth;

/**
 * Class GuitarController
 * @package App\Http\Controllers
 */
class GuitarController extends Controller
{
    /**
     * Contains the authenticated user.
     *
     * @var array
     */
    private $user;

    /**
     * Constructor.
     *
     * Check if the user has the 'user' role.
     * Get the authenticated user and save it to the $user variable.
     */
    public function __construct()
    {
        $this->middleware('role:user')->except('show', 'experiences', 'getLocations');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show details for the specified guitar.
     *
     * @param \App\Guitar $guitar
     * @return \Illuminate\Http\Response
     */
    public function show(Guitar $guitar)
    {
        $ip_address = request()->ip();
        $user_location = geoip($ip_address);
        $user_coords = ['lat' => $user_location->lat, 'lng' => $user_location->lon];

        /**
         * Get all guitars from the specified guitar's brand.
         * Take a maximum of 10 records.
         */
        $brand_guitars = $guitar->guitarBrand->guitars()->take(10)->get()->except(['id' => $guitar->id]);

        $types = $guitar->guitarTypes()->pluck('id');

        $guitars = Guitar::has('guitarTypes');

        /**
         * Get all guitars with minimum the same types as the specified guitar.
         * Take a maximum of 10 records.
         */
        foreach ($types as $type) {
            $guitars->whereHas('guitarTypes', function ($q) use ($type) {
                $q->where('id', $type);
            });
        }

        $similar_guitars = $guitars->take(10)->get()->except(['id' => $guitar->id]);

        /**
         * If the previous query gives no results back, execute the following query.
         * This query returns less accurate, but still relevant guitars.
         * Take a maximum of 10 records.
         */
        if ($similar_guitars->isEmpty()) {
            $similar_guitars = Guitar::whereHas('guitarTypes', function ($q) use ($types) {
                $q->whereIn('id', $types);
            })->take(10)->get()->except(['id' => $guitar->id]);
        }

        $users_query        = $guitar->users();
        $guitar_users       = $users_query->take(4)->get();

        $guitar_user_count  = $users_query
            ->where('location_lat', '!=', null)
            ->where('location_lng', '!=', null)
            ->count();

        return view('guitar.show', [
            'guitar_users'          => $guitar_users,
            'guitar_user_count'     => $guitar_user_count,
            'guitar'                => $guitar,
            'brand_guitars'         => $brand_guitars,
            'similar_guitars'       => $similar_guitars,
            'user_coords'           => json_encode($user_coords),
        ]);
    }

    /**
     * Show the 'create image' form.
     *
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function createImage(Guitar $guitar)
    {
        return view('guitar.image.create', [
            'guitar' => $guitar,
        ]);
    }

    /**
     * Store the guitar image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function storeImage(Request $request, Guitar $guitar)
    {
        foreach ($request->images as $upload) {
            $image = new GuitarImage();

            $image->image_uri   = $upload->store('images', 'public');
            $image->guitar_id   = $guitar->id;
            $image->user_id     = $this->user->id;

            $image->save();
        }

        return redirect(route('guitar.show', [
            'guitar' => $guitar->id
        ]));
    }

    /**
     * Get the marker locations for the current google maps viewport.
     *
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLocations(Guitar $guitar)
    {
        $users = $guitar->users()
            ->where('location_lat', '!=', null)
            ->where('location_lng', '!=', null)
            ->get();

        return $users;
    }

    /**
     * Get all experiences listed for this guitar.
     *
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function experiences(Guitar $guitar)
    {
        return view('guitar.experiences', [
            'guitar' => $guitar,
        ]);
    }
}
