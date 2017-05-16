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
            // Remove whitespace from both sides of the string.
            $term = trim($input);

            $users = User::where('first_name', 'LIKE', $term)
                ->orWhere('last_name', 'LIKE', $term)
                ->take(6)
                ->get();

            $guitars = Guitar::where('name', 'LIKE', $term)
                ->take(6)
                ->get();

        } else {
            return back();
        }

        return view('results', [
            'users' => $users,
            'guitars' => $guitars,
            'search_term' => $term,
        ]);
    }
}
