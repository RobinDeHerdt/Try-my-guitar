<?php

namespace App\Http\Controllers;

use Session;
use App\Contactmessage;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the 'about' page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('about');
    }

    /**
     * Store the contact message.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact(Request $request)
    {
        $contact_message = new Contactmessage();

        $contact_message->email     = $request->email;
        $contact_message->message   = $request->message;

        $contact_message->save();

        Session::flash('success-message', 'Thanks for your message!');

        return back();
    }
}
