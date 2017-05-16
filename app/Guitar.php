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

    /**
     * A guitar has many guitar images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function guitarimages()
    {
        return $this->hasMany('App\Guitarimage');
    }
}
