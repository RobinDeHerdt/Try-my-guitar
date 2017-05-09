<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Channel;
use App\User;
use App\Message;
use Illuminate\Support\Facades\Session;
use Auth;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function index()
    {
        $user       = Auth::user();
        $channels   = $user->channels()->where('accepted', true)->get();

        return view('conversation.index', [
            'channels' => $channels,
            'user' => $user,
        ]);
    }

    /**
     * Store a message in database and broadcast it to the current channel.
     *
     * @param  Request $request
     * @param  Channel id
     * @return Response
     */
    public function store(Request $request, $channel_id)
    {
        $user       = Auth::user();
        $channel    = Channel::find($channel_id);

        $message    = new Message();

        $message->message       = $request->message;
        $message->channel_id    = $channel_id;
        $message->sender_id     = $user->id;

        $participants = $channel->users()->get();

        // Set channel to unseen for every participant.
        foreach ($participants as $participant) {
            if ($participant->id !== $user->id) {
                $participant->channels()->updateExistingPivot($channel_id, ['seen' => false]);
            }
        }

        $message->save();

        broadcast(new MessageSent($message, $user))->toOthers();
    }

    /**
     * Show the initial chat channel and its messages.
     *
     * @param  Channel id
     * @return Response
     */
    public function show($channel_id)
    {
        $user = Auth::user();

        if ($user->channels->contains($channel_id)) {
            $channel  = Channel::find($channel_id);
            $messages = $channel->messages()->get();
        } else {
            abort(403);
        }

        return view('conversation.show', [
            'messages' => $messages,
            'channel'  => $channel,
        ]);
    }


    /**
     * Fetch all messages for the specified channel.
     *
     * @param  Channel id
     * @return Response
     */
    public function messages($channel_id)
    {
        $user = Auth::user();

        $messages = Channel::find($channel_id)->messages()->with('user')->get();

        $user->channels()->updateExistingPivot($channel_id, ['seen' => true]);

        return $messages;
    }

    public function seen($channel_id)
    {
        $user = Auth::user();

        $user->channels()->updateExistingPivot($channel_id, ['seen' => true]);

        return response('success', 200);
    }

    public function invite(Request $request)
    {
        $user = User::find($request->user_id);
        $channel = Channel::find($request->channel_id);

        if (!$user->channels()->where('channel_id', $channel->id)->exists()) {
            $user->channels()->attach($channel->id, ['accepted' => false]);

            Session::flash('success-message', 'Invite sent!');
        } else {
            Session::flash('info-message', 'This invite was already sent. Please wait for the persons answer.');
        }

        return back();
    }
}
