<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('channel.{id}', function ($user, $channel_id) {
    return $user->channels->contains($channel_id) && $user->channels()->wherePivot('accepted', true)->exists();
});

Broadcast::channel('user-channel.{id}', function ($user) {
    return $user->id === Auth::user()->id;
});