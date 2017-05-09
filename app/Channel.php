<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The users that belong to the channel.
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('seen', 'accepted');
    }

    /**
     * A channel has many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
