<?php

namespace App\Http\Controllers;

use Auth;
use App\CtaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $cta_items = CtaItem::orderBy('active', 'desc')->get();

        return view('admin.cta.index', [
            'cta_items' => $cta_items,
        ]);
    }

    /**
     * Display the spcecified call to action item.
     *
     * @param \App\CtaItem  $cta_item
     * @return \Illuminate\Http\Response
     */
    public function show(CtaItem $cta_item)
    {
        return view('admin.cta.show', [
            'cta_item' => $cta_item,
        ]);
    }

    /**
     * Display call to action items.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cta.create');
    }

    /**
     * Store call to action item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cta_item = new CtaItem();

        $cta_item->title        = $request->title;
        $cta_item->icon_class   = $request->icon_class;
        $cta_item->content_en   = $request->content_en;
        $cta_item->content_nl   = $request->content_nl;

        $active_items = CtaItem::where('active', true)->get();

        if ($active_items->count() >= 3) {
            $cta_item->active = false;
        } else {
            $cta_item->active = true;
        }

        $cta_item->save();

        Session::flash('success-message', 'Call to action item saved successfully.');

        return redirect(route('admin.cta.index'));
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

    /**
     * Store call to action item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\CtaItem  $cta_item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CtaItem $cta_item)
    {
        $cta_item->title        = $request->title;
        $cta_item->icon_class   = $request->icon_class;
        $cta_item->content_en   = $request->content_en;
        $cta_item->content_nl   = $request->content_nl;

        $active_items = CtaItem::where('active', true)->count();

        if ($active_items > 3) {
            $cta_item->active = false;
        } else {
            $cta_item->active = true;
        }

        $cta_item->save();

        Session::flash('success-message', 'Call to action item updated successfully.');

        return redirect(route('admin.cta.index'));
    }

    /**
     * Delete the specified call to action item.
     *
     * @param \App\CtaItem  $cta_item
     * @return \Illuminate\Http\Response
     */
    public function destroy(CtaItem $cta_item)
    {
        $cta_item->delete();

        Session::flash('success-message', 'Call to action item was removed successfully.');

        return redirect(route('admin.cta.index'));
    }

    /**
     * Delete the specified call to action item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\CtaItem  $cta_item
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, CtaItem $cta_item)
    {
        $active_items = CtaItem::where('active', true)->count();

        if ($request->value === "on") {
            if ($active_items < 3) {
                $cta_item->active = true;
                $cta_item->save();
            } else {
                Session::flash('error-message', 'There can only be 3 call to action items active at a time.');
            }
        } else {
            $cta_item->active = false;
            $cta_item->save();
        }

        return redirect(route('admin.cta.index'));
    }
}
