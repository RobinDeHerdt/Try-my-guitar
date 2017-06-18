<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * A vote belongs to an experience.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function experience()
    {
        return $this->belongsTo('App\Experience');
    }

    /**
     * A vote belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
