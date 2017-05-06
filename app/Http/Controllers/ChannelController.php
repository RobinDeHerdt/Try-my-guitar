<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use Auth;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function show($id)
    {
        $user = Auth::user();

        if ($user->channels->contains($id)) {
            $messages = Channel::find($id)->messages()->get();
        } else {
            abort(403);
        }

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
