<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InviteSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User object
     *
     * @var User
     */
    private $receiver;

    /**
     * Channel id
     *
     * @var integer id
     */
    public $channel;

    /**
     * User object
     *
     * @var User
     */
    public $sender;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Channel $channel, User $receiver, User $sender)
    {
        $this->channel  = $channel;
        $this->sender   = $sender;
        $this->receiver = $receiver;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user-channel.' . $this->receiver->id);
    }
}
