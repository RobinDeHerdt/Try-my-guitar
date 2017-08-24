<?php

namespace App\Http\Controllers;

use App\ContactMessage;
use App\Guitar;
use App\GuitarImage;
use App\Report;
use App\User;

/**
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * Display the administrator control panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports          = Report::where('reviewed', false)->orderBy('created_at', 'desc')->get();
        $users            = User::orderBy('created_at', 'desc')->take(5)->get();
        $guitars          = Guitar::orderBy('created_at', 'desc')->take(5)->get();
        $guitarimages     = GuitarImage::orderBy('created_at', 'desc')->take(5)->get();
        $contact_messages = ContactMessage::where('seen', false)->get();

        return view('admin.dashboard', [
            'contact_messages' => $contact_messages,
            'reports' => $reports,
            'users' => $users,
            'guitars' => $guitars,
            'guitarimages' => $guitarimages,
        ]);
    }
}
