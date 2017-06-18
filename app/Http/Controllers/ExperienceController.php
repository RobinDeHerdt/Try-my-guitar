<?php

namespace App\Http\Controllers;

use App\Experience;
use Auth;
use App\Vote;
use Illuminate\Http\Request;

/**
 * Class ExperienceController
 * @package App\Http\Controllers
 */
class ExperienceController extends Controller
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
        $this->middleware('role:user');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Submit a vote .
     *
     * @param \Illuminate\Http\Request  $request
     * @param \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function vote(Request $request, Experience $experience)
    {
        $this->validate($request, [
            'value' => 'required',
        ]);

        $vote_query = $experience->votes()
            ->where('experience_id', $experience->id)
            ->where('user_id', $this->user->id);

        if (!$vote_query->exists()) {
            $vote = new Vote();

            $vote->value            = $request->value;
            $vote->experience_id    = $experience->id;
            $vote->user_id          = $this->user->id;
        } else {
            $vote = $vote_query->first();
            $vote->value            = $request->value;
        }

        $vote->save();

        return back();
    }
}
