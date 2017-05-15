<?php

namespace App\Http\Controllers;

use Session;
use App\Contactmessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Contactmessage $contact_message)
    {
        $contact_messages = Contactmessage::paginate(15);

        return view('admin.contactmessage.index', [
            'contact_messages' => $contact_messages,
        ]);
    }

    /**
     * Store the contact message.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact_message = new Contactmessage();

        $contact_message->email     = $request->email;
        $contact_message->message   = $request->message;

        $contact_message->save();

        Session::flash('success-message', 'Thanks for your message!');

        return back();
    }

    /**
     * Show the specified contact message.
     *
     * @param Contactmessage $contact_message
     * @return \Illuminate\Http\Response
     */
    public function show(Contactmessage $contact_message)
    {
        $contact_message->seen = true;

        $contact_message->save();

        return view('admin.contactmessage.show', [
            'contact_message' => $contact_message,
        ]);
    }
}
