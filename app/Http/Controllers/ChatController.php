<?php

namespace App\Http\Controllers;

use App\Events\ChatJoined;
use App\Events\ChatLeft;
use App\Events\ChatNameChanged;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Channel;
use App\Invite;
use App\User;
use App\Message;
use Illuminate\Support\Facades\Session;
use Auth;

class ChatController extends Controller
{
    /**
     * Contains the authenticated user.
     *
     * @var array
     */
    private $user;

    /**
     * Constructor.
     *
     * Check if the user has the 'user' role.
     * Get the authenticated user and save it to the $user variable.
     */
    public function __construct()
    {
        $this->middleware('role:user');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Display a listing of conversations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels   = $this->user->channels()->where('accepted', true)->get();

        return view('chat.index', [
            'channels' => $channels,
            'user' => $this->user,
        ]);
    }

    /**
     * Edit the specified channel name.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $channel = Channel::find($request->channel_id);

        $channel->name = $request->channel_name;

        $channel->save();

        broadcast(new ChatNameChanged($channel))->toOthers();

        return back();
    }

    /**
     * Store a message in database and broadcast it to the current channel.
     *
     * @param  Request  $request
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Channel $channel)
    {
        $message    = new Message();

        $message->message       = $request->message;
        $message->channel_id    = $channel->id;
        $message->sender_id     = $this->user->id;

        $participants = $channel->users()->get();

        // Set channel to unseen for every participant.
        foreach ($participants as $participant) {
            if ($participant->id !== $this->user->id) {
                $participant->setChannelNotSeen($channel->id);
            }
        }

        $message->save();

        broadcast(new MessageSent($message, $this->user))->toOthers();

        return response('success');
    }

    /**
     * Show the initial chat channel and its messages.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        if ($this->user->channels()->wherePivot('accepted', true)->where('channel_id', $channel->id)->exists()) {
            $messages = $channel->messages()->get();
        } else {
            abort(403);
        }

        return view('chat.show', [
            'messages' => $messages,
            'channel'  => $channel,
        ]);
    }

    /**
     * Fetch all messages for the specified channel.
     *
     * @param  \App\Channel  $channel
     * @return Message
     */
    public function messages(Channel $channel)
    {
        $messages = $channel->messages()->with('user')->get();

        $this->user->setChannelSeen($channel->id);

        return $messages;
    }

    /**
     * Fetch all channel information.
     *
     * @param  integer $id
     * @return Channel
     */
    public function channel($id)
    {
        // Get the channel with all of its accepted users.
        $channel = Channel::where('id', $id)->with(['users' => function ($query) {
            $query->where('accepted', true);
        }])->get();

        return $channel;
    }

    /**
    * Fetch all user channels.
    *
    * @return Channel
    */
    public function channels()
    {
        $channels = $this->user->channels()->get();

        return $channels;
    }


    /**
     * Set specified channel to 'seen' for the authenticated user.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function seen(Channel $channel)
    {
        $this->user->setChannelSeen($channel->id);

        return response('success', 200);
    }

    /**
     * Set up a chat invite for the specified user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendInvite(Request $request)
    {
        $user = User::find($request->user_id);

        /**
         * If the channel id is sent with the request,
         * add the specified user this channel.
         *
         * If not, create a new channel and add the specified user
         * and the authenticated user to the newly created channel.
         */
        if ($request->channel_id) {
            $channel = Channel::find($request->channel_id);

            // Check if the user already has an invite for the specified channel.
            if (!$user->channels()->where('channel_id', $channel->id)->exists()) {
                Session::flash('success-message', 'Invite sent!');
            } else {
                Session::flash('info-message', 'This invite was already sent. Please wait for the persons answer.');

                return back();
            }
        } else {
            $channel = new Channel();
            $channel->name = $this->user->first_name . "'s chat";
            $channel->save();

            // The creator of the channel gets the 'accepted' status.
            $this->user->addAcceptedUserToChannel($channel->id);

            Session::flash('success-message', 'Chat created and invite sent!');
        }

        $invite = new Invite();

        $invite->sender_id      = $this->user->id;
        $invite->receiver_id    = $user->id;
        $invite->channel_id     = $channel->id;

        $invite->save();

        // The user invited to the channel gets the 'not accepted' status.
        $user->addUnacceptedUserToChannel($channel->id);

        return back();
    }

    /**
     * Handle the user invite response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inviteResponse(Request $request)
    {
        $invite = Invite::find($request->invite_id);
        $response = $request->response;

        if (!isset($invite->channel)) {
            if ($response) {
                Session::flash('error-message', 'Oops! We can\'t add you to the chat. The invite was either cancelled or expired.');
            }

            return back();
        }

        $channel = $invite->channel;
        $channel_id = $channel->id;

        if ($response) {
            $this->user->acceptUserToChannel($channel_id);
            $this->user->removeChannelInvites($channel_id);

            broadcast(new ChatJoined($channel, $this->user))->toOthers();

            return redirect(route('chat.show', ['id' => $channel_id]));
        } else {
            $receiver = $invite->receiver;
            
            $receiver->removeUserFromChannel($channel_id);
            $receiver->removeChannelInvites($channel_id);

            return back();
        }
    }

    /**
     * Leave the specified channel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function leave(Request $request, Channel $channel)
    {
        $this->user->removeUserFromChannel($channel->id);

        broadcast(new ChatLeft($channel, $this->user))->toOthers();

        Session::flash('success-message', 'You have left the chat.');

        return redirect(route('chat.index'));
    }
}
