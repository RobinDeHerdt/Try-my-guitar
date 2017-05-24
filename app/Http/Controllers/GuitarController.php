<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuitarImage;
use App\Guitar;

class GuitarController extends Controller
{
    /**
     * Show details for the specified guitar.
     *
     * @param \App\Guitar $guitar
     * @return \Illuminate\Http\Response
     */
    public function show(Guitar $guitar)
    {
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

        $owners_query       = $guitar->owners();
        $experiencers_query = $guitar->experiencers();

        $owners             = $owners_query->take(4)->get();
        $experiencers       = $experiencers_query->take(4)->get();

        $owners_coords      = $owners_query->get('location_lat','location_lng','location');

        $owner_locations = [];

        foreach ($owners_coords as $owner) {
            array_push($owner_locations, ['lat' => $owner->location_lat, 'lng' => $owner->location_lng]);
        }

        $owner_count        = $owners_query->count();
        $experiencer_count  = $experiencers_query->count();

        return view('guitar.show', [
            'owners'            => $owners,
            'owner_count'       => $owner_count,
            'experiencers'      => $experiencers,
            'experiencer_count' => $experiencer_count,
            'guitar'            => $guitar,
            'brand_guitars'     => $brand_guitars,
            'similar_guitars'   => $similar_guitars,
            'owner_locations'   => json_encode($owner_locations),
        ]);
    }
}
