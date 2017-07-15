<?php

namespace App\Http\Controllers;

use App\GuitarBrand;
use App\GuitarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\GuitarImage;
use App\Guitar;
use App\User;
use App\Traits\Exp;
use Validator;
use Auth;

/**
 * Class GuitarController
 * @package App\Http\Controllers
 */
class GuitarController extends Controller
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
        $this->middleware('role:user')->except('show', 'experiences', 'getLocations');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show the specified guitar.
     *
     * @param \App\Guitar $guitar
     * @return \Illuminate\Http\Response
     */
    public function show(Guitar $guitar)
    {
        $ip_address = request()->ip();
        $user_location = geoip($ip_address);
        $user_coords = ['lat' => $user_location->lat, 'lng' => $user_location->lon];

        /**
         * Get all guitars from the specified guitar's brand.
         * Take a maximum of 10 records.
         */
        $brand_guitars = $guitar->guitarBrand->guitars()->take(10)->get()->except(['id' => $guitar->id]);

        $types = $guitar->guitarTypes()->pluck('id');

        $guitars = Guitar::has('guitarTypes');

        /**
         * Get all guitars with minimum the same types as the specified guitar.
         * Take a maximum of 10 records.
         */
        foreach ($types as $type) {
            $guitars->whereHas('guitarTypes', function ($q) use ($type) {
                $q->where('id', $type);
            });
        }

        $similar_guitars = $guitars->take(10)->get()->except(['id' => $guitar->id]);

        /**
         * If the previous query gives no results back, execute the following query.
         * This query returns less accurate, but still relevant guitars.
         * Take a maximum of 10 records.
         */
        if ($similar_guitars->isEmpty()) {
            $similar_guitars = Guitar::whereHas('guitarTypes', function ($q) use ($types) {
                $q->whereIn('id', $types);
            })->take(10)->get()->except(['id' => $guitar->id]);
        }

        $users_query        = $guitar->users();
        $guitar_users       = $users_query->take(4)->get();

        $guitar_user_count  = $users_query
            ->where('location_lat', '!=', null)
            ->where('location_lng', '!=', null)
            ->count();

        return view('guitar.show', [
            'guitar_users'          => $guitar_users,
            'guitar_user_count'     => $guitar_user_count,
            'guitar'                => $guitar,
            'brand_guitars'         => $brand_guitars,
            'similar_guitars'       => $similar_guitars,
            'user_coords'           => json_encode($user_coords),
        ]);
    }

    /**
     * Show the 'create guitar' form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = GuitarBrand::all();
        $types  = GuitarType::all();

        return view('guitar.create', [
            'brands'    => $brands,
            'types'     => $types,
        ]);
    }

    /**
     * Store the created guitar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images.*'      => 'file|image|mimes:jpeg,png,bmp,gif|max:1000',
            'name'          => 'required',
            'description'   => 'required',
            'types'         => 'required',
            'brand'         => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('guitar.create'))
                ->withErrors($validator)
                ->withInput();
        } else {
            $guitar = new Guitar();

            $guitar->name           = $request->name;
            $guitar->description    = $request->description;
            $guitar->brand_id       = $request->brand;
            $guitar->contributor_id = $this->user->id;

            $guitar->save();

            $guitar->guitarTypes()->attach($request->types);

            if ($request->images) {
                foreach ($request->images as $upload) {
                    $image = new GuitarImage();

                    $image->image_uri = $upload->store('images/guitar', 'public');
                    $image->guitar_id = $guitar->id;
                    $image->user_id = $this->user->id;

                    $image->save();
                }
            }

            $this->addExp($this->user, 100 + (count($request->images) * 25));

            return redirect(route('guitar.show', [
                'guitar' => $guitar->id
            ]));
        }
    }

    /**
     * Show the 'create image' form.
     *
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function createImage(Guitar $guitar)
    {
        return view('guitar.image.create', [
            'guitar' => $guitar,
        ]);
    }

    /**
     * Store the created guitar image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function storeImage(Request $request, Guitar $guitar)
    {
        $validator = Validator::make($request->all(), [
            'images'    => 'required',
            'images.*'  => 'file|image|mimes:jpeg,png,bmp,gif|max:1000',
        ], [
            'required'  => 'The image field is required.',
            'filled'    => 'The image field is required.',
            'file'      => 'The upload must contain a file.',
            'image'     => 'The file must be an image.',
            'mimes'     => 'The image must be one of the following types: :mimes',
            'max'       => 'The upload must be a maximum of :max kB',
        ]);

        if ($validator->fails()) {
            return redirect(route('guitar.image.create',
                ['guitar' => $guitar]
            ))->withErrors($validator);
        } else {
            foreach ($request->images as $upload) {
                $image = new GuitarImage();

                $image->image_uri   = $upload->store('images/guitar', 'public');
                $image->guitar_id   = $guitar->id;
                $image->user_id     = $this->user->id;

                $image->save();
            }

            $this->addExp($this->user, count($request->images) * 25);

            return redirect(route('guitar.show', [
                'guitar' => $guitar->id
            ]));
        }
    }

    /**
     * Get the marker locations for the current google maps viewport.
     *
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLocations(Guitar $guitar)
    {
        $users = $guitar->users()
            ->where('location_lat', '!=', null)
            ->where('location_lng', '!=', null)
            ->get();

        return $users;
    }

    /**
     * Fetch all experiences for the specified guitar.
     *
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function experiences(Guitar $guitar)
    {
        return view('guitar.experiences', [
            'guitar' => $guitar,
        ]);
    }

    /**
     * Delete the specified guitar.
     *
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function destroy(Guitar $guitar)
    {
        if ($guitar->contributor->id === $this->user->id) {
            if ($guitar->users->count() < 1) {
                $guitar->guitarTypes()->detach();
                $image_amount = $guitar->guitarImages()->count();
                $guitar->delete();
                $this->subtractExp($this->user, 100 + ($image_amount * 25));
                Session::flash('success-message', __('flash.guitar-deleted'));
            } else {
                Session::flash('error-message', __('flash.part-of-collection'));
            }
        } else {
            Session::flash('error-message', __('flash.error-guitar-not-deleted'));
        }

        return back();
    }

    /**
     * Delete the specified guitar image.
     *
     * @param  \App\GuitarImage  $guitarImage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function destroyImage(GuitarImage $guitarImage)
    {
        if ($guitarImage->user->id === $this->user->id) {
            $guitarImage->delete();
            $this->subtractExp($this->user, 25);
            Session::flash('success-message', __('flash.image-deleted'));
        } else {
            Session::flash('error-message', __('flash-error-image-not-deleted'));
        }

        return back();
    }
}
