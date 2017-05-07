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

        $channels = $user->channels()->where('seen', false)->take(3)->get();

        $messages_array = [];

        foreach ($channels as $channel) {
            $message = $channel->messages()->orderBy('created_at', 'desc')->first();
            if ($message) {
                array_push($messages_array, $message);
            }
        }

        $messages = collect($messages_array);

        return view('dashboard', [
            'messages' => $messages,
        ]);
    }
}
