<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guitar extends Model
{
    /**
     * A guitar belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_guitar');
    }
}
