<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Guitar;
use function MongoDB\BSON\toJSON;

class SearchController extends Controller
{
    private $users;
    private $guitars;

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
            // Split the string into terms and remove whitespace from both sides of the string.
            $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

            $this->search($terms);
        } else {
            return back();
        }

        return view('results', [
            'users' => $this->users,
            'guitars' => $this->guitars,
            'search_term' => $input,
        ]);
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

            $this->search($terms);
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

    /**
     * Search for guitars and users using the specified terms.
     */
    private function search($terms)
    {
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
}
