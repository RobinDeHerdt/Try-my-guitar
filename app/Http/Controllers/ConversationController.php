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
    private $user;

    public function __construct()
    {
        $this->middleware('role:user');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    public function index()
    {
        $channels   = $this->user->channels()->where('accepted', true)->get();

        return view('conversation.index', [
            'channels' => $channels,
            'user' => $this->user,
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
        $channel    = Channel::find($channel_id);

        $message    = new Message();

        $message->message       = $request->message;
        $message->channel_id    = $channel_id;
        $message->sender_id     = $this->user->id;

        $participants = $channel->users()->get();

        // Set channel to unseen for every participant.
        foreach ($participants as $participant) {
            if ($participant->id !== $this->user->id) {
                $participant->channels()->updateExistingPivot($channel_id, ['seen' => false]);
            }
        }

        $message->save();

        broadcast(new MessageSent($message, $this->user))->toOthers();
    }

    /**
     * Show the initial chat channel and its messages.
     *
     * @param  Channel id
     * @return Response
     */
    public function show($channel_id)
    {
        if ($this->user->channels->contains($channel_id) && $this->user->channels()->wherePivot('accepted', true)->exists()) {
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
        $messages = Channel::find($channel_id)->messages()->with('user')->get();

        $this->user->channels()->updateExistingPivot($channel_id, ['seen' => true]);

        return $messages;
    }

    public function seen($channel_id)
    {
        $this->user->channels()->updateExistingPivot($channel_id, ['seen' => true]);

        return response('success', 200);
    }

    public function invite(Request $request)
    {
        $user       = User::find($request->user_id);

        if ($request->channel_id) {
            $channel = Channel::find($request->channel_id);

            if (!$user->channels()->where('channel_id', $channel->id)->exists()) {
                $user->channels()->attach($channel->id, [
                    'accepted' => false,
                    'invited_by_id' => $this->user->id
                ]);

                Session::flash('success-message', 'Invite sent!');
            } else {
                Session::flash('info-message', 'This invite was already sent. Please wait for the persons answer.');
            }
        } else {
            $channel = new Channel();
            $channel->name = $this->user->first_name . "'s chat";
            $channel->save();

            // The creator of the channel gets the accepted status.
            $this->user->channels()->attach($channel->id, ['accepted' => true]);

            // Set up an invite for the invited person.
            $user->channels()->attach($channel->id, [
                'accepted' => false,
                'invited_by_id' => $this->user->id
            ]);

            Session::flash('success-message', 'Chat created and invite sent!');
        }

        return back();
    }
}
