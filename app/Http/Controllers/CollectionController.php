<?php

namespace App\Http\Controllers;

use App\User;
use App\Experience;
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
        return view('collection.create', [
            'user' => $this->user,
        ]);
    }

    /**
     * Save the guitar and experience to the collection.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'guitar' => 'required',
        ]);

        $guitar = Guitar::find($request->guitar);

        if (!$this->user->guitars->contains($guitar->id)) {
            $this->user->guitars()->attach($guitar->id);

            $experience_exists = Experience::where('user_id', $this->user->id)->where('guitar_id', $guitar->id)->exists();

            if ($request->experience && !$experience_exists) {
                $experience = new Experience();

                $experience->experience = $request->experience;
                $experience->user_id    = $this->user->id;
                $experience->guitar_id  = $guitar->id;

                $experience->save();
            }
            Session::flash('success-message', $guitar->name . ' (' . $guitar->guitarBrand->name . ')' . ' was added to your collection!');

            return redirect(route('collection.show', ['id' => $this->user->id]));
        }

        Session::flash('info-message', $guitar->name . ' (' . $guitar->guitarBrand->name . ')' . ' is already a part of your collection!');
        return back();
    }

    /**
     * Remove guitar from the user's collection.
     *
     * @param \App\Guitar  $guitar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guitar $guitar)
    {
        $this->user->guitars()->detach($guitar->id);

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
