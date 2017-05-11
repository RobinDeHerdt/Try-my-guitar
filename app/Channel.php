<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * A channel belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('seen', 'accepted');
    }

    /**
     * A channel has many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    /**
     * Remove the channel if only one person is in the channel and no invites are sent.
     */
    public function removeChannelIfEmpty()
    {
        if ($this->users()->count() === 1) {
            $this->users()->detach();
        }
    }

    /**
     * A channel has many invites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invites()
    {
        return $this->hasMany('App\Invite');
    }
}
