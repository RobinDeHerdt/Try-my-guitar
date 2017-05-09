<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function index()
    {
        $user = Auth::user();

        $channels = $user->channels()->where('seen', false)->where('accepted', true)->take(3)->get();

        $messages_array = [];

        foreach ($channels as $channel) {
            $message = $channel->messages()
                ->where('sender_id', '!=', $user->id)
                ->orderBy('created_at', 'desc')->first();

            if ($message) {
                array_push($messages_array, $message);
            }
        }

        $messages = collect($messages_array);

        $invitations = $user->channels()->where('accepted', false)->get();

        return view('dashboard', [
            'messages' => $messages,
            'invitations' => $invitations,
        ]);
    }
}
