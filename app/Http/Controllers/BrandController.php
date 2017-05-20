<?php

namespace App\Http\Controllers;

use App\GuitarType;
use Illuminate\Http\Request;
use App\GuitarBrand;

class BrandController extends Controller
{
    /**
     * Filter variables
     * @var array
     */
    private $filter_types   = [];
    private $filter_brands  = [];

    /**
     * Display page for the specified brand.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(GuitarBrand $brand, Request $request)
    {
        $types = GuitarType::all();

        if ($request->query('types')) {
            $this->filter_types = $request->query('types');
        }

        $query      = $brand->guitars();
        $guitars    = $this->filterResults($query)->paginate(10);

        return view('brand.show', [
            'brand'         => $brand,
            'guitars'       => $guitars,
            'types'         => $types,
            'filter_types'  => $this->filter_types,
        ]);
    }

    /**
     * Filter the 'guitar search' query.
     *
     * @return $query
     */
    private function filterResults($query) {
        if($this->filter_types) {
            foreach ($this->filter_types as $filter_type) {
                $query->whereHas('guitarTypes', function($q) use ($filter_type) {
                    $q->where('id', $filter_type);
                });
            }
        }

        if($this->filter_brands) {
            if($this->filter_brands) {
                $query->where(function($q){
                    foreach ($this->filter_brands as $filter_brand) {
                        $q->orWhere('brand_id', $filter_brand);
                    }
                });
            }
        }

        return $query;
    }
}
