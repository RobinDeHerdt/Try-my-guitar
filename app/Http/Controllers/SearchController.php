<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Traits\Filter;
use App\GuitarBrand;
use App\GuitarType;
use App\Guitar;
use App\User;
use Auth;
use DB;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    use Filter;

    /**
     * Auto complete variables.
     * @var
     */
    private $users;
    private $guitars;

    /**
     * Search results variables.
     * @var
     */
    private $most_relevant_users;
    private $less_relevant_users;
    private $most_relevant_guitars;
    private $less_relevant_guitars;

    /**
     * Result count variables.
     * @var
     */
    private $guitars_count;
    private $users_count;

    /**
     * Pagination amount variables.
     * @var integer
     */
    private $guitar_pagination_amount   = 8;
    private $user_pagination_amount     = 8;

    /**
     * Result amount variables.
     * @var integer
     */
    private $guitar_results_amount   = 4;
    private $user_results_amount     = 4;

    /**
     * Filter variables.
     * @var mixed
     */
    private $filter_brands   = [];
    private $filter_types    = [];
    private $filter_category = [];
    private $filter_proximity;
    private $filter_proximity_range;

    /**
     * Geolocation variables.
     * @var
     */
    private $lat;
    private $lng;

    /**
     * Display the results page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {
        // Strip the input of unwanted tags.
        $input = strip_tags($request->term);

        // Check if the input is not empty.
        if (!empty($input) && !ctype_space($input)) {
            $this->filter_category          = $request->query('category');
            $this->filter_types             = ($request->query('types') ? $request->query('types') : []);
            $this->filter_brands            = ($request->query('brands') ? $request->query('brands') : []);
            $this->filter_proximity         = ($request->query('proximity') === null ? false : true);
            $this->filter_proximity_range   = $request->query('range');

            switch ($this->filter_category) {
                case 'guitar':
                    $this->guitarSearch($input, true);
                    // Return empty user collections to avoid errors in the view.
                    $this->most_relevant_users = collect();
                    $this->less_relevant_users = collect();
                    break;

                case 'user':
                    $this->userSearch($input, true);
                    // Return empty guitar collections to avoid errors in the view.
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
            'filter_proximity'              => $this->filter_proximity,
            'filter_proximity_range'        => $this->filter_proximity_range,
            'search_term'                   => $input,
            'types'                         => $types,
            'brands'                        => $brands,
        ]);
    }

    /**
     * User search query.
     *
     * @param  string  $input
     * @param  boolean  $paginate_results
     */
    private function userSearch($input, $paginate_results = false)
    {
        // Split the string into terms and remove whitespace from both sides of the string.
        $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->location_lat && $user->location_lng) {
                $this->lat = $user->location_lat;
                $this->lng = $user->location_lng;
            }
        }

        if (!isset($this->lat) && !isset($this->lng)) {
            $ip_address = request()->ip();
            $user       = geoip($ip_address);

            $this->lat  = $user->lat;
            $this->lng  = $user->lon;
        }

        $haversine  =
            '(6371 * acos(
                cos(radians(' . $this->lat . ')) * 
                cos(radians(location_lat)) * 
                cos(radians(location_lng) - radians(' . $this->lng . ')) + sin(radians(' . $this->lat . ')) * 
                sin(radians(location_lat ))
            ))';

        /**
         * Set up a query to fetch the most relevant results. Don't execute yet.
         *
         * This query assumes the user's name in the format of "first_name last_name",
         * because auto complete applies the same format.
         */
        if (count($terms) >= 2) {
            $this->most_relevant_users = User::selectRaw("*, {$haversine} AS distance")
                ->where('first_name', 'like', $terms[0])
                ->where('last_name', 'like', $terms[1])
                ->take(6)
                ->get();
        } else {
            // When the format isn't matched, return an empty collection to avoid errors in the view.
            $this->most_relevant_users = collect();
        }

        // Set up a query to fetch less relevant results. Don't execute yet.
        $less_relevant_query = User::selectRaw("*, {$haversine} AS distance")
            ->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('first_name', 'like', '%'.$term.'%')
                      ->orWhere('last_name', 'like', '%'.$term.'%');
                }
            });

        // Get the id's of all the most relevant search results.
        // Use them to prevent duplicate result listing in the less relevant results section.
        $most_relevant_users_keys = $this->most_relevant_users->pluck('id')->all();

        // Run the query through user filters. Don't execute yet.
        $filtered_query = $this->filterUsers(
            $less_relevant_query,
            $haversine,
            $this->filter_proximity,
            $this->filter_proximity_range
        );

        // Check if results should be paginated or not.
        if ($paginate_results) {
            // Execute the query to fetch less relevant results. Apply pagination.
            $this->less_relevant_users = $filtered_query
                ->whereNotIn('id', $most_relevant_users_keys)
                ->orWhereHas('guitars', function ($q) use ($input, $haversine) {
                    $q->where('name', $input)->where('owned', true);
                    if ($this->filter_proximity_range) {
                        $q->whereRaw("{$haversine} < ?", [$this->filter_proximity_range]);
                    }
                })
                ->paginate($this->user_pagination_amount);

            // Count the total number of results. For some reason, code fails here because of 'distance' alias.
            $this->users_count = $this->less_relevant_users->total() + $this->most_relevant_users->count();

            // Append all query parameters that were received with the initial request.
            foreach (Input::except('page') as $input => $value) {
                $this->less_relevant_users->appends($input, $value);
            }
        } else {
            // Execute the query to fetch less relevant results.
            $this->less_relevant_users = $filtered_query
                ->orWhereHas('guitars', function ($q) use ($input) {
                    $q->where('name', $input)
                      ->where('owned', true);
                })
                ->take($this->user_results_amount)
                ->get()
                ->except($most_relevant_users_keys);

            // Count the total number of results. For some reason, code fails here because of 'distance' alias.
            $this->users_count =
                ($filtered_query->count() - $this->most_relevant_users->count())
                + $this->most_relevant_users->count();
        }
    }

    /**
     * Guitar search query.
     *
     * @param  string  $input
     * @param  boolean  $paginate_results
     */
    private function guitarSearch($input, $paginate_results = false)
    {
        // Split the string into terms and remove whitespace from both sides of the string.
        $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

        // Set up a query to fetch the most relevant results. Don't execute yet.
        $most_relevant_query = Guitar::where('name', 'like', $input);

        // Set up a query to fetch less relevant results. Don't execute yet.
        $less_relevant_query = Guitar::where(function ($q) use ($terms) {
            foreach ($terms as $term) {
                $q->orWhere('name', 'like', '%'.$term.'%');
            }
        });

        // Run the query through brand and category filters and execute it to get the most relevant results.
        $this->most_relevant_guitars = $this->filterGuitars(
            $most_relevant_query,
            $this->filter_types,
            $this->filter_brands
        )->get();

        // Get the id's of all the most relevant search results.
        // Use them to prevent duplicate result listing in the less relevant results section.
        $most_relevant_guitars_keys = $this->most_relevant_guitars->pluck('id')->all();

        // Run the query through brand and category filters. Don't execute it yet.
        $filtered_query = $this->filterGuitars(
            $less_relevant_query,
            $this->filter_types,
            $this->filter_brands
        );

        // Check if results should be paginated or not.
        if ($paginate_results) {
            // Execute the query to fetch less relevant results. Apply pagination.
            $this->less_relevant_guitars = $filtered_query
                ->whereNotIn('id', $most_relevant_guitars_keys)
                ->paginate($this->guitar_pagination_amount);

            // Count the total number of results.
            $this->guitars_count = $this->less_relevant_guitars->total() + $this->most_relevant_guitars->count();

            // Append all query parameters that were received with the initial request.
            foreach (Input::except('page') as $input => $value) {
                $this->less_relevant_guitars->appends($input, $value);
            }
        } else {
            // Execute the query to fetch less relevant results.
            $this->less_relevant_guitars = $filtered_query
                ->take($this->guitar_results_amount)
                ->get()
                ->except($most_relevant_guitars_keys);

            // Count the total number of results.
            $this->guitars_count =
                ($filtered_query->count() - $this->most_relevant_guitars->count())
                + $this->most_relevant_guitars->count();
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
        // Strip the input of unwanted tags.
        $input = strip_tags($request->term);

        // Check if the input is not empty.
        if (!empty($input) && !ctype_space($input)) {
            // Split the string into terms and remove whitespace from both sides of the string.
            $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

            // Set up a query to fetch users and execute it. Fetch up to 5 users.
            $this->users = User::where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('first_name', 'like', '%'.$term.'%')
                        ->orWhere('last_name', 'like', '%'.$term.'%');
                }
            })->take(5)->get();

            // Set up a query to fetch users and execute it. Fetch up to 5 guitars.
            $this->guitars = Guitar::where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('name', 'like', '%'.$term.'%');
                }
            })->take(5)->get();
        }

        $result_array = [];

        // jQuery UI auto complete requires data to be in the label - value format.
        foreach ($this->guitars as $guitar) {
            array_push($result_array, [
                "value" => $guitar->name,
                "label" => $guitar->name  . ' (' .  $guitar->guitarBrand->name. ')',
            ]);
        }

        // jQuery UI auto complete requires data to be in the label - value format.
        foreach ($this->users as $user) {
            array_push($result_array, [
                "value" => $user->fullName(),
                "label" => $user->fullName(),
            ]);
        }

        return response()->json($result_array);
    }
}
