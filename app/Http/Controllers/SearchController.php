<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Guitar;

class SearchController extends Controller
{
    /**
     * Execute search and return the results.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $input = strip_tags($request->term);

        // Check if the input is not empty.
        if (!empty($input) && !ctype_space($input)) {
            // Split the string into terms and remove whitespace from both sides of the string.
            $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

            $users = User::where(function($q) use ($terms)
            {
                foreach ($terms as $term)
                {
                    $q->orWhere('first_name', 'like', '%'.$term.'%')
                      ->orWhere('last_name', 'like', '%'.$term.'%');
                }
            })->take(6)->get();

            $guitars = Guitar::where(function($q) use ($terms)
            {
                foreach ($terms as $term)
                {
                    $q->orWhere('name', 'like', '%'.$term.'%');
                }
            })->take(6)->get();

        } else {
            return back();
        }

        return view('results', [
            'users' => $users,
            'guitars' => $guitars,
            'search_term' => $input,
        ]);
    }
}
