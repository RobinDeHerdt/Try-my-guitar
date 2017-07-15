<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Filter;
use App\GuitarBrand;
use App\GuitarType;

/**
 * Class BrandController
 * @package App\Http\Controllers
 */
class BrandController extends Controller
{
    use Filter;

    /**
     * Filter variables
     * @var array
     */
    private $filter_types   = [];
    private $filter_brands  = [];

    /**
     * Display the specified brand's page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  GuitarBrand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, GuitarBrand $brand)
    {
        $types = GuitarType::all();

        if ($request->query('types')) {
            $this->filter_types = $request->query('types');
        }

        $query      = $brand->guitars();
        $guitars    = $this->filterGuitars($query, $this->filter_types, $this->filter_brands)->paginate(10);

        return view('brand.show', [
            'brand'         => $brand,
            'guitars'       => $guitars,
            'types'         => $types,
            'filter_types'  => $this->filter_types,
        ]);
    }
}
