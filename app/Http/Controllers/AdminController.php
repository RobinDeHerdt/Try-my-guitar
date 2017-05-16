<?php

namespace App\Http\Controllers;

use App\ContactMessage;

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

        return view('admin.dashboard', [
            'contact_messages' => $contact_messages,
        ]);
    }
}
