<?php

namespace App\Http\Controllers;

use App\GuitarImage;
use App\Traits\Exp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class GuitarimageController extends Controller
{
    use Exp;

    /**
    * Display a listing of guitarimages (admin).
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $guitarimages = GuitarImage::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.guitarimage.index', [
            'guitarimages' => $guitarimages,
        ]);
    }

    /**
     * Delete the specified guitarimage.
     *
     * @param  \App\Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function destroy(GuitarImage $guitarimage)
    {
          $this->subtractExp($guitarimage->user, 25);

          $guitarimage->delete();

          Session::flash('success-message', 'The image was deleted. 25 exp was subtracted from ' . $guitarimage->user->fullName());

        return back();
    }
}
