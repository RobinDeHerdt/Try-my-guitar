<?php

namespace App\Http\Controllers;

/**
 * Class CollectionController
 * @package App\Http\Controllers
 */
class CookieController extends Controller
{
    /**
     * Set cookie.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return response('200')->cookie('cookie-popup', 'checked');
    }
}
