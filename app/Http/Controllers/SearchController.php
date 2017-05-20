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
    /**
     * Auto complete variables
     */
    private $users;
    private $guitars;

    /**
     * Search results variables
     */
    private $most_relevant_users;
    private $less_relevant_users;
    private $most_relevant_guitars;
    private $less_relevant_guitars;

    /**
     * Filter variables
     * @var array
     */
    private $filter_brands   = [];
    private $filter_types    = [];
    private $filter_category = [];

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
            $this->filter_category  =  $request->query('category');

            /**
             * When a filter is set, set the search category to 'guitar'.
             *
             * If there is no query string set for 'types' or 'brands',
             * return an empty array, to avoid errors in the view.
             */
            if($request->query('types')) {
                $this->filter_types     = $request->query('types');
                $this->filter_category  = 'guitar';
            } else {
                $this->filter_types     = [];
            }

            if($request->query('brands')) {
                $this->filter_brands    = $request->query('brands');
                $this->filter_category  = 'guitar';
            } else {
                $this->filter_brands    = [];
            }

            switch($filter_category = $this->filter_category) {
                case 'guitar':
                    $this->guitarSearch($input);
                    $this->most_relevant_users = collect();
                    $this->less_relevant_users = collect();
                    break;

                case 'user':
                    $this->userSearch($input);
                    $this->most_relevant_guitars = collect();
                    $this->less_relevant_guitars = collect();
                    break;

                default:
                    $this->userSearch($input);
                    $this->guitarSearch($input);
            }
        } else {
            return back();
        }

        $types  = GuitarType::all();
        $brands = GuitarBrand::all();

        return view('results', [
            'most_relevant_users'   => $this->most_relevant_users,
            'less_relevant_users'   => $this->less_relevant_users,
            'most_relevant_guitars' => $this->most_relevant_guitars,
            'less_relevant_guitars' => $this->less_relevant_guitars,
            'filter_types'          => $this->filter_types,
            'filter_brands'         => $this->filter_brands,
            'filter_category'       => $this->filter_category,
            'search_term'           => $input,
            'types'                 => $types,
            'brands'                => $brands,
        ]);
    }

    /**
     * Display the explore page.
     *
     * @return \Illuminate\Http\Response
     */
    public function explore()
    {

        return view('explore');
    }

    /**
     * User search query.
     */
    private function userSearch($input) {
        // Split the string into terms and remove whitespace from both sides of the string.
        $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

        if(count($terms) >= 2) {
            $this->most_relevant_users = User::where('first_name', 'like', '%'.$terms[0].'%')->where('last_name', 'like', '%'.$terms[1].'%')->take(6)->get();
        } else {
            $this->most_relevant_users = collect();
        }

        $less_relevant_query = User::where(function($q) use ($terms)
        {
            foreach ($terms as $term)
            {
                $q->orWhere('first_name', 'like', '%'.$term.'%')
                    ->orWhere('last_name', 'like', '%'.$term.'%');
            }
        });

        // If there are relevant results, avoid outputting them again with the less relevant results.
        if($this->most_relevant_users->isNotEmpty()) {
            $most_relevant_users_keys = $this->most_relevant_users->pluck('id')->all();
            $this->less_relevant_users = $less_relevant_query->take(8)->get()->except($most_relevant_users_keys);
        } else {
            $this->less_relevant_users = $less_relevant_query->take(8)->get();
        }
    }

    /**
     * Guitar search query.
     */
    private function guitarSearch($input) {
        // Split the string into terms and remove whitespace from both sides of the string.
        $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

        $most_relevant_query = Guitar::where('name', 'like', $input);

        $less_relevant_query = Guitar::where(function($q) use ($terms) {
            foreach ($terms as $term) {
                $q->orWhere('name', 'like', '%'.$term.'%');
            }
        });

        $this->most_relevant_guitars = $this->filterResults($most_relevant_query)->get();
        $most_relevant_guitars_keys  = $this->most_relevant_guitars->pluck('id')->all();

        $this->less_relevant_guitars = $this->filterResults($less_relevant_query)->take(8)->get()->except($most_relevant_guitars_keys);
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

    /**
     * Retrieve data for the auto complete feature.
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

        // jQuery UI auto complete requires data to be in the label - value format.
        foreach($this->users as $user) {
            array_push($result_array, ["value" => $user->fullName(), "label" => $user->fullName()]);
        }
        foreach($this->guitars as $guitar) {
            array_push($result_array, ["value" => $guitar->name, "label" => $guitar->name  . ' (' .  $guitar->guitarBrand->name. ')']);
        }

        return response()->json($result_array);
    }
}
