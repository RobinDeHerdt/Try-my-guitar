<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Channel;
use App\Message;
use Auth;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }


    // Conversation overview
    public function index()
    {
        $user       = Auth::user();
        $channels   = $user->channels()->get();

        return view('conversation.index', [
            'channels' => $channels,
            'user' => $user,
        ]);
    }

    /**
     * Store a message in database and broadcast it to the current channel.
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

    // Show channel with messages.
    public function show($id)
    {
        $user = Auth::user();

        if ($user->channels->contains($id)) {
            $messages = Channel::find($id)->messages()->get();
            $channel = Channel::find($id);
        } else {
            abort(403);
        }

        return view('conversation.show', [
            'messages' => $messages,
            'channel' => $channel,
        ]);
    }

    // Api messages.
    public function messages($id)
    {
        $messages = Channel::find($id)->messages()->with('user')->get();

        return $messages;
    }
}
