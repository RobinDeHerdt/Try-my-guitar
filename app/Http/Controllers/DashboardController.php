<?php

namespace App\Http\Controllers;

use Auth;

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
        $channels = $this->user->channels()->where('seen', false)->where('accepted', true)->take(3)->get();

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

        $invitations = $this->user->channels()->where('accepted', false)->get();

        return view('dashboard', [
            'messages' => $messages,
            'invitations' => $invitations,
        ]);
    }
}
