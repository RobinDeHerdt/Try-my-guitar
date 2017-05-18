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
        // Get all guitars from the specified guitar's brand. Take a maximum of 10 records.
        $brand_guitars = $guitar->guitarBrand->guitars()->take(10)->get();

        $types = $guitar->guitarTypes()->pluck('id');

        /**
         * Get all guitars with the same types as the specified guitar. Take a maximum of 10 records.
         *
         * $similar_guitars = Guitar::whereHas('guitarTypes', function($q) use ($types) {
         * foreach($types as $type) {
         *   // @todo make this work.
         *   $q->where('id', $type->id);
         * }
         * })->take(10)->get();
         */

        // Get all guitars with the same types as the specified guitar. Take a maximum of 10 records.
        $similar_guitars = Guitar::whereHas('guitarTypes', function($q) use ($types) {
            $q->whereIn('id', $types);
        })->take(10)->get();

        return view('guitar.show', [
            'guitar' => $guitar,
            'brand_guitars' => $brand_guitars->except(['id' => $guitar->id]),
            'similar_guitars' => $similar_guitars->except(['id' => $guitar->id]),
        ]);
    }
}
