<?php

namespace App\Http\Controllers;

use Auth;
use Session;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
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
     * Display the authenticated user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = $this->user->channels()->where('seen', false)->where('accepted', true)->get();

        $messages_array = [];

        foreach ($channels as $channel) {
            $message = $channel->messages()
                ->where('sender_id', '!=', $this->user->id)
                ->orderBy('created_at', 'desc')->first();

            if ($message) {
                array_push($messages_array, $message);
            }
        }

        $messages = collect($messages_array);

        $received_invites   = $this->user->receivedInvites()->get();
        $sent_invites       = $this->user->sentInvites()->get();

        return view('dashboard', [
            'received_invites'  => $received_invites,
            'sent_invites'      => $sent_invites,
            'messages'          => $messages,
            'user'              => $this->user,
        ]);
    }
}
