<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Guitar;
use Auth;

/**
 * Class CollectionController
 * @package App\Http\Controllers
 */
class CollectionController extends Controller
{
    /**
     * Contains the authenticated user.
     *
     * @var array
     */
    private $user;

    /**
     * Constructor.
     *
     * Check if the user has the 'user' role.
     * Get the authenticated user and save it to the $user variable.
     */
    public function __construct()
    {
        $this->middleware('role:user')->except('show');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show the specified user's collection.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('collection.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form to add a guitar to the collection.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('collection.create');
    }

    /**
     * Save the guitar and experience to the collection.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guitar = Guitar::find($request->guitar);

        if (!$this->user->guitars->contains($guitar->id)) {
            $this->user->guitars()->attach($guitar->id, [
                'experience' => $request->experience,
                'owned' => $request->owned,
            ]);

            Session::flash('success-message', $guitar->name . ' (' . $guitar->guitarBrand->name . ')' . ' was added to your collection!');
        } else {
            Session::flash('info-message', $guitar->name . ' (' . $guitar->guitarBrand->name . ')' . ' was already a part of your collection!');
        }

        return back();
    }

    /**
     * Retrieve data for the auto complete feature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autoComplete(Request $request)
    {
        $guitars = [];

        $input = strip_tags($request->term);
        // Check if the input is not empty.
        if (!empty($input) && !ctype_space($input)) {
            // Split the string into terms and remove whitespace from both sides of the string.
            $terms = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

            $guitars = Guitar::where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('name', 'like', '%'.$term.'%');
                }
            })->take(6)->get();
        }

        $result_array = [];

        // jQuery UI auto complete requires data to be in the label - value format.
        foreach ($guitars as $guitar) {
            array_push($result_array, [
                "value" => $guitar->name,
                "label" => $guitar->name  . ' (' .  $guitar->guitarBrand->name. ')',
                "id"    => $guitar->id,
            ]);
        }

        return response()->json($result_array);
    }
}
