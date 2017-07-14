<?php

namespace App\Http\Controllers;

use Session;
use App\ContactMessage;
use Illuminate\Http\Request;

/**
 * Class ContactController
 * @package App\Http\Controllers
 */
class ContactController extends Controller
{
    /**
     * Display a listing of contact messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact_messages = ContactMessage::paginate(15);

        return view('admin.contactmessage.index', [
            'contact_messages' => $contact_messages,
        ]);
    }

    /**
     * Store the contact message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact_message = new ContactMessage();

        $contact_message->email     = $request->email;
        $contact_message->message   = $request->message;
        $contact_message->subject   = $request->subject;

        $contact_message->save();

        Session::flash('success-message', __('flash.contact-message'));

        return redirect(route('about').'#alert');
    }

    /**
     * Show the specified contact message.
     *
     * @param ContactMessage $contact_message
     * @return \Illuminate\Http\Response
     */
    public function show(ContactMessage $contact_message)
    {
        $contact_message->seen = true;

        $contact_message->save();

        return view('admin.contactmessage.show', [
            'contact_message' => $contact_message,
        ]);
    }
}
