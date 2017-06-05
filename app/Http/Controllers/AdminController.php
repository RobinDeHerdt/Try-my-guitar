<?php

namespace App\Http\Controllers;

use App\ContactMessage;
use App\Report;

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
        $contact_messages = ContactMessage::where('seen', false)->get();
        $reports = Report::where('reviewed', false)->get();

        return view('admin.dashboard', [
            'contact_messages' => $contact_messages,
            'reports' => $reports,
        ]);
    }
}
