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

    /**
     * A guitar has many experiences.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function experiences()
    {
        return $this->hasMany('App\Experience');
    }
}
