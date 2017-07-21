<?php

namespace App\Http\Controllers;

/**
 * Class CollectionController
 * @package App\Http\Controllers
 */
class CookieController extends Controller
{
    /**
     * Set cookie. Expires after 1 year.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return response('200')->cookie(
            'cookie-popup',
            'checked',
            time() + (365 * 24 * 60 * 60)
        );
    }
}
