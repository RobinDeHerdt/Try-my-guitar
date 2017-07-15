<?php

namespace App\Http\Controllers;

use App\User;
use App\Experience;
use App\Traits\Exp;
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
    use Exp;

    /**
     * Contains the authenticated user.
     *
     * @var \App\User
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
        return view('profile.collection.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the 'add guitar to collection' form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.collection.create', [
            'user' => $this->user,
        ]);
    }

    /**
     * Save the guitar and/or experience to the collection.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'guitar' => 'required',
            'experience' => 'max:1024'
        ]);

        $guitar = Guitar::find($request->guitar);

        if (!$this->user->guitars->contains($guitar->id)) {
            $this->user->guitars()->attach($guitar->id);

            $experience_exists = Experience::where('user_id', $this->user->id)
                ->where('guitar_id', $guitar->id)
                ->exists();

            if ($request->experience && !$experience_exists) {
                $experience = new Experience();

                $experience->experience = $request->experience;
                $experience->user_id    = $this->user->id;
                $experience->guitar_id  = $guitar->id;

                $experience->save();

                $this->addExp($this->user, 75);
            }

            Session::flash('success-message', __('flash.guitar-added-to-collection', [
                'guitar' => $guitar->name,
                'brand' => $guitar->guitarBrand->name
            ]));

            return redirect(route('collection.show', [
                'id' => $this->user->id
            ]) . "#guitar-" . $guitar->id);
        }

        Session::flash('info-message', __('flash.guitar-already-in-collection', [
            'guitar' => $guitar->name,
            'brand' => $guitar->guitarBrand->name,
        ]));

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

        Session::flash('success-message', __('flash.removed-from-collection'));

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
