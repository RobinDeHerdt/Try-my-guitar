<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search_term = strip_tags($request->search_term);

        $users = User::where('first_name', 'LIKE', $search_term)
            ->orWhere('last_name', 'LIKE', $search_term)
            ->paginate(10);



        return view('results', [
            'users' => $users,
            'search_term' => $search_term,
        ]);
    }
}
