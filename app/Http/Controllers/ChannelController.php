<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function show($id)
    {
        $messages = Channel::find($id)->messages()->get();

        return view('channel', [
            'messages' => $messages,
        ]);
    }

    public function messages($id)
    {
        $messages = Channel::find($id)->messages()->with('user')->get();

        return $messages;
    }
}
