<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Experience;
use App\Guitar;
use Auth;
use App\Traits\Exp;
use App\Vote;
use Illuminate\Http\Request;

/**
 * Class ExperienceController
 * @package App\Http\Controllers
 */
class ExperienceController extends Controller
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
        $this->middleware('role:user')->except('index');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show experience create form.
     *
     * @param \App\Guitar  $guitar
     * @return \Illuminate\Http\Response
     */
    public function create(Guitar $guitar)
    {
        return view('experience.create', [
            'guitar' => $guitar,
        ]);
    }

    /**
     * Store an experience.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \App\Guitar  $guitar
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Guitar $guitar)
    {
        if (!Experience::where('user_id', $this->user->id)->where('guitar_id', $guitar->id)->exists()) {
            $experience = new Experience();

            $experience->experience = $request->experience;
            $experience->user_id    = $this->user->id;
            $experience->guitar_id  = $guitar->id;

            $experience->save();

            $this->addExp($this->user, 75);

            return redirect(route('profile.experiences', [
                'user' => $this->user->id
            ]) . "#experience-" . $experience->id);
        } else {
            return back();
        }
    }

    /**
     * Update an experience.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        if ($experience->user->id === $this->user->id) {
            $experience->experience = $request->experience;
            $experience->save();
        }

        return Redirect::to(URL::previous() . "#experience-" . $experience->id);
    }

    /**
     * Remove an experience.
     *
     * @param \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        if ($experience->user->id === $this->user->id) {
            Vote::where('experience_id', $experience->id)->delete();
            $experience->delete();

            $this->subtractExp($this->user, 75);

            Session::flash('success-message', __('flash.experience-removed'));
        }

        return back();
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

        return Redirect::to(URL::previous() . "#experience-" . $experience->id);
    }
}
