<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Traits\Exp;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    use Exp;

    /**
     * Contains the authenticated user.
     *
     * @var \App\User
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
     * Display the authenticated user's dashboard.
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

        $current_level      = $this->calculateLevel($this->user->exp);
        $current_level_exp  = $this->calculateCurrentLevelExp($current_level);
        $next_level_exp     = $this->calculateNextLevelExp($current_level);

        return view('dashboard', [
            'received_invites'  => $received_invites,
            'sent_invites'      => $sent_invites,
            'messages'          => $messages,
            'user'              => $this->user,
            'current_level'     => $current_level,
            'current_level_exp' => $current_level_exp,
            'next_level_exp'    => $next_level_exp,
        ]);
    }
}
