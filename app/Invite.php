<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    /**
     * An invite belongs to a user (sender).
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * An invite belongs to a user (receiver).
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function receiver()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * An invite belongs to a channel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }
}
