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
        // Get all guitars from the specified guitar's brand.
        $brand_guitars = $guitar->guitarBrand->guitars()->get();

        $types = $guitar->guitarTypes()->get();

        // Get all guitars with the same types as the specified guitar.
        $similar_guitars = Guitar::whereHas('guitarTypes', function($q) use ($types)
        {
            foreach($types as $type) {
                $q->where('type_id', $type->id);
            }

        })->get();

        return view('guitar.show', [
            'guitar' => $guitar,
            'brand_guitars' => $brand_guitars->except(['id' => $guitar->id]),
            'similar_guitars' => $similar_guitars->except(['id' => $guitar->id]),
        ]);
    }
}
