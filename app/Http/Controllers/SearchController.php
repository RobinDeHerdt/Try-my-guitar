<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search_term = strip_tags($request->term);

        $users = User::where('first_name', 'LIKE', $search_term)
            ->orWhere('last_name', 'LIKE', $search_term)
            ->take(6)
            ->get();

        return view('results', [
            'users' => $users,
            'search_term' => $search_term,
        ]);
    }
}
