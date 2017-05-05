<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Message;
use Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function index()
    {
        return view('profile');
    }

    /**
    * Fetch all messages
    *
    * @return Message
    */
    public function show()
    {
        $messages = Message::with('user')->get();

        return $messages;
    }

    /**
     * Store message in database
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $message = new Message();

        $message->message = $request->message;
        $message->user_id = $user->id;

        $message->save();

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message saved'];
    }
}
