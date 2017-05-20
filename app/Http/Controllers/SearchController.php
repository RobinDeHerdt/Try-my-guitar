<?php

namespace App\Http\Controllers;

use App\GuitarBrand;
use App\GuitarType;
use Illuminate\Http\Request;
use App\User;
use App\Guitar;
use function MongoDB\BSON\toJSON;

class SearchController extends Controller
{
    private $users;
    private $guitars;
    private $filter_brands = [];
    private $filter_types  = [];

    /**
     * Display the results page.
     *
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {
        $input = strip_tags($request->term);

        // Check if the input is not empty.
        if (!empty($input) && !ctype_space($input)) {
            // If there is no querystring set for 'types' or 'brands',
            // return an empty array, to avoid errors in the view.
            $this->filter_types     = ($request->query('types') ? $request->query('types') : []);
            $this->filter_brands    = ($request->query('brands') ? $request->query('brands') : []);

            $this->userSearch($input);
            $this->guitarSearch($input);
        } else {
            return back();
        }

        $types  = GuitarType::all();
        $brands = GuitarBrand::all();

        return view('results', [
            'users'         => $this->users,
            'guitars'       => $this->guitars,
            'search_term'   => $input,
            'types'         => $types,
            'brands'        => $brands,
            'filter_types'  => $this->filter_types,
            'filter_brands' => $this->filter_brands,
        ]);
    }

    /**
     * User search query.
     */
    private function userSearch($input) {
        // Split the string into terms and remove whitespace from both sides of the string.
        $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

        if(count($terms) >= 2) {
            $most_relevant_results = User::where('first_name', 'like', '%'.$terms[0].'%')->where('last_name', 'like', '%'.$terms[1].'%')->take(6)->get();
        } else {
            $most_relevant_results = collect();
        }

        $less_relevant_results = User::where(function($q) use ($terms)
        {
            foreach ($terms as $term)
            {
                $q->orWhere('first_name', 'like', '%'.$term.'%')
                    ->orWhere('last_name', 'like', '%'.$term.'%');
            }
        })->take(6)->get();

        $this->users = $most_relevant_results->merge($less_relevant_results);
    }

    /**
     * Guitar search query.
     */
    private function guitarSearch($input) {
        // Split the string into terms and remove whitespace from both sides of the string.
        $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

        $most_relevant_query = Guitar::where('name', 'like', '%'.$input.'%');
        
        $less_relevant_query = Guitar::where(function($q) use ($terms) {
            foreach ($terms as $term) {
                $q->orWhere('name', 'like', '%'.$term.'%');
            }
        });

        $most_relevant_results = $this->filterResults($most_relevant_query)->get();
        $less_relevant_results = $this->filterResults($less_relevant_query)->get();

        $this->guitars = $most_relevant_results->merge($less_relevant_results);
    }

    /**
     * Filter the 'guitar search' query.
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
            foreach ($this->filter_brands as $filter_brand) {
                $query->whereHas('guitarBrand', function($q) use ($filter_brand) {
                    $q->where('id', $filter_brand);
                });
            }
        }

        return $query;
    }

    /**
     * Retrieve data for the autocomplete feature.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request) {
        $input = strip_tags($request->term);
        // Check if the input is not empty.
        if (!empty($input) && !ctype_space($input)) {
            // Split the string into terms and remove whitespace from both sides of the string.
            $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

            $this->users = User::where(function($q) use ($terms)
            {
                foreach ($terms as $term)
                {
                    $q->orWhere('first_name', 'like', '%'.$term.'%')
                        ->orWhere('last_name', 'like', '%'.$term.'%');
                }
            })->take(6)->get();

            $this->guitars = Guitar::where(function($q) use ($terms)
            {
                foreach ($terms as $term)
                {
                    $q->orWhere('name', 'like', '%'.$term.'%');
                }
            })->take(6)->get();
        }

        $result_array = [];

        foreach($this->users as $user) {
            array_push($result_array, ["value" => $user->fullName(), "label" => $user->fullName()]);
        }

        foreach($this->guitars as $guitar) {
            array_push($result_array, ["value" => $guitar->name, "label" => $guitar->name  . ' (' .  $guitar->guitarBrand->name. ')']);
        }

        return response()->json($result_array);
    }
}
