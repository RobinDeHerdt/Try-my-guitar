<?php

namespace App\Http\Controllers;

use Auth;
use App\CtaItem;
use Illuminate\Http\Request;

class CtaItemController extends Controller
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
     * Get the authenticated user and save it to the $user variable.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
    * Display call to action items.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $cta_items = CtaItem::orderBy('active')->get();

        return view('admin.cta.index', [
            'cta_items' => $cta_items,
        ]);
    }

    /**
     * Display the edit form for the specified call to action item.
     *
     * @param \App\CtaItem  $cta_item
     * @return \Illuminate\Http\Response
     */
    public function edit(CtaItem $cta_item)
    {
        return view('admin.cta.edit', [
            'cta_item' => $cta_item,
        ]);
    }
}
