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
     * A guitar belongs to many owners.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function owners()
    {
        return $this->belongsToMany('App\User', 'user_guitar')->wherePivot('owned', true)->withPivot('experience');
    }

    /**
     * A guitar belongs to many experiencers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function experiencers()
    {
        return $this->belongsToMany('App\User', 'user_guitar')->wherePivot('owned', false)->withPivot('experience');;
    }

    /**
     * A guitar has many guitar images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function guitarImages()
    {
        return $this->hasMany('App\GuitarImage');
    }

    /**
     * A guitar belongs to a guitar brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function guitarBrand()
    {
        return $this->belongsTo('App\GuitarBrand', 'brand_id');
    }

    /**
     * A guitar belongs to many guitar types.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function guitarTypes()
    {
        return $this->belongsToMany('App\GuitarType', 'guitar_type', 'guitar_id', 'type_id');
    }
}
