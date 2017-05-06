<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Message;
use App\Channel;
use Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function index()
    {
        $user       = Auth::user();
        $channels   = $user->channels()->get();

        return view('messages', [
            'channels' => $channels,
            'user' => $user,
        ]);
    }

    /**
     * Store message in database
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, $id)
    {
        $user = Auth::user();

        $message = new Message();

        $message->message = $request->message;
        $message->sender_id = $user->id;
        $message->channel_id = $id;

        $message->save();

        broadcast(new MessageSent($message, $user))->toOthers();

        return ['status' => 'Message saved'];
    }
}
