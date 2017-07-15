<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Filter;
use App\GuitarBrand;
use App\GuitarType;

/**
 * Class TypeController
 * @package App\Http\Controllers
 */
class TypeController extends Controller
{
    use Filter;

    /**
     * Filter variables
     * @var array
     */
    private $filter_brands   = [];
    private $filter_types    = [];

    /**
     * Display the specified type's page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  GuitarType  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, GuitarType $type)
    {
        $types  = GuitarType::all()->except($type->id);
        $brands = GuitarBrand::all();

        if ($request->query('types')) {
            $this->filter_types = $request->query('types');
        }

        if ($request->query('brands')) {
            $this->filter_brands = $request->query('brands');
        }

        $query      = $type->guitars();
        $guitars    = $this->filterGuitars($query, $this->filter_types, $this->filter_brands)->paginate(10);

        return view('type.show', [
            'type'              => $type,
            'types'             => $types,
            'brands'            => $brands,
            'guitars'           => $guitars,
            'filter_brands'     => $this->filter_brands,
            'filter_types'      => $this->filter_types,
        ]);
    }
}
