<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Filter;
use App\GuitarBrand;
use App\GuitarType;
use App\Guitar;
use App\User;

class SearchController extends Controller
{
    use Filter;

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

    private $guitars_count;
    private $users_count;

    private $guitar_pagination_amount   = 8;
    private $user_pagination_amount     = 8;

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
     * @param  \Illuminate\Http\Request  $request
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
            if ($request->query('types')) {
                $this->filter_types     = $request->query('types');
            }

            if ($request->query('brands')) {
                $this->filter_brands    = $request->query('brands');
            }

            switch ($filter_category = $this->filter_category) {
                case 'guitar':
                    $this->guitarSearch($input, true);
                    // Return an empty collection to avoid errors in the view.
                    $this->most_relevant_users = collect();
                    $this->less_relevant_users = collect();
                    break;

                case 'user':
                    $this->userSearch($input, true);
                    // Return an empty collection to avoid errors in the view.
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
            'most_relevant_users'           => $this->most_relevant_users,
            'less_relevant_users'           => $this->less_relevant_users,
            'users_count'                   => $this->users_count,
            'most_relevant_guitars'         => $this->most_relevant_guitars,
            'less_relevant_guitars'         => $this->less_relevant_guitars,
            'guitars_count'                 => $this->guitars_count,
            'filter_types'                  => $this->filter_types,
            'filter_brands'                 => $this->filter_brands,
            'filter_category'               => $this->filter_category,
            'search_term'                   => $input,
            'types'                         => $types,
            'brands'                        => $brands,
        ]);
    }

    /**
     * User search query.
     *
     * @param  string  $input
     */
    private function userSearch($input, $paginate_results = false)
    {
        // Split the string into terms and remove whitespace from both sides of the string.
        $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

        if (count($terms) >= 2) {
            $this->most_relevant_users = User::where('first_name', 'like', $terms[0])
                ->where('last_name', 'like', $terms[1])
                ->take(6)
                ->get();
        } else {
            $this->most_relevant_users = collect();
        }

        $less_relevant_query = User::where(function ($q) use ($terms) {
            foreach ($terms as $term) {
                $q->orWhere('first_name', 'like', '%'.$term.'%')
                    ->orWhere('last_name', 'like', '%'.$term.'%');
            }
        });

        // Get the id's of all the most relevant search results.
        // Use them to prevent double result listing in the less relevant results section.
        $most_relevant_users_keys = $this->most_relevant_users->pluck('id')->all();

        // @todo Add filters here, obviously.
        // Run the query through brand and category filters.
        $filtered_query = $less_relevant_query;

        if ($paginate_results) {
            $this->less_relevant_users = $filtered_query->paginate($this->user_pagination_amount);
            $this->users_count = $filtered_query->count() + $this->most_relevant_users->count();
        } else {
            $this->less_relevant_users = $filtered_query->take(4)->get()->except($most_relevant_users_keys);
            $this->users_count = ($filtered_query->count() - $this->most_relevant_users->count()) + $this->most_relevant_users->count();
        }
    }

    /**
     * Guitar search query.
     *
     * @param  string  $input
     */
    private function guitarSearch($input, $paginate_results = false)
    {
        // Split the string into terms and remove whitespace from both sides of the string.
        $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

        $most_relevant_query = Guitar::where('name', 'like', $input);

        $less_relevant_query = Guitar::where(function ($q) use ($terms) {
            foreach ($terms as $term) {
                $q->orWhere('name', 'like', '%'.$term.'%');
            }
        });

        // Run the query through brand and category filters and get the results.
        $this->most_relevant_guitars = $this->filterResults($most_relevant_query, $this->filter_types, $this->filter_brands)->get();

        // Get the id's of all the most relevant search results.
        // Use them to prevent double result listing in less relevant results section.
        $most_relevant_guitars_keys  = $this->most_relevant_guitars->pluck('id')->all();

        // Run the query through brand and category filters.
        $filtered_query = $this->filterResults($less_relevant_query, $this->filter_types, $this->filter_brands);

        if($paginate_results) {
            $this->less_relevant_guitars = $filtered_query->paginate($this->guitar_pagination_amount);
            $this->guitars_count = $filtered_query->count() + $this->most_relevant_guitars->count();
        } else {
            $this->less_relevant_guitars = $filtered_query->take(4)->get()->except($most_relevant_guitars_keys);
            $this->guitars_count = ($filtered_query->count() - $this->most_relevant_guitars->count()) + $this->most_relevant_guitars->count();
        }
    }

    /**
     * Retrieve data for the auto complete feature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autoComplete(Request $request)
    {
        $input = strip_tags($request->term);
        // Check if the input is not empty.
        if (!empty($input) && !ctype_space($input)) {
            // Split the string into terms and remove whitespace from both sides of the string.
            $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

            $this->users = User::where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('first_name', 'like', '%'.$term.'%')
                        ->orWhere('last_name', 'like', '%'.$term.'%');
                }
            })->take(6)->get();

            $this->guitars = Guitar::where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('name', 'like', '%'.$term.'%');
                }
            })->take(6)->get();
        }

        $result_array = [];

        // jQuery UI auto complete requires data to be in the label - value format.
        foreach ($this->guitars as $guitar) {
            array_push($result_array, [
                "value" => $guitar->name,
                "label" => $guitar->name  . ' (' .  $guitar->guitarBrand->name. ')',
            ]);
        }

        foreach ($this->users as $user) {
            array_push($result_array, [
                "value" => $user->fullName(),
                "label" => $user->fullName(),
            ]);
        }

        return response()->json($result_array);
    }
}
