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
        foreach($types as $type) {
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
        if($similar_guitars->isEmpty()) {
            $similar_guitars = Guitar::whereHas('guitarTypes', function($q) use ($types) {
                $q->whereIn('id', $types);
            })->take(10)->get()->except(['id' => $guitar->id]);
        }

        return view('guitar.show', [
            'guitar' => $guitar,
            'brand_guitars' => $brand_guitars,
            'similar_guitars' => $similar_guitars,
        ]);
    }
}
