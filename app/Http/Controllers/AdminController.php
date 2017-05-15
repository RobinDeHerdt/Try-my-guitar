<?php

namespace App\Http\Controllers;

use App\Contactmessage;

class AdminController extends Controller
{
    /**
     * Display the administrator control panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact_messages = Contactmessage::where('seen', false);

        return view('admin.dashboard', [
            'contact_messages' => $contact_messages,
        ]);
    }
}
