<?php

namespace App\Http\Controllers;

use App\GuitarBrand;
use App\GuitarType;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Filter variables
     * @var array
     */
    private $filter_brands   = [];
    private $filter_types    = [];

    public function show(GuitarType $type, Request $request)
    {
        $types  = GuitarType::all()->except($type->id);
        $brands = GuitarBrand::all();

        if($request->query('types')) {
            $this->filter_types     = $request->query('types');
        }

        if($request->query('brands')) {
            $this->filter_brands     = $request->query('brands');
        }

        $query      = $type->guitars();
        $guitars    = $this->filterResults($query)->paginate(10);

        return view('type.show', [
            'type'              => $type,
            'types'             => $types,
            'brands'            => $brands,
            'guitars'           => $guitars,
            'filter_brands'     => $this->filter_brands,
            'filter_types'      => $this->filter_types,
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
