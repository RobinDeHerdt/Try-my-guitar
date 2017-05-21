<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuitarBrand;
use App\GuitarType;


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

        return view('explore', [
            'types'     => $types,
            'brands'    => $brands,
        ]);
    }
}
