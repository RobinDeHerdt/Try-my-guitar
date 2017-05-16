<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuitarType extends Model
{
    /**
     * A type of guitar belongs to many guitars.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function guitars()
    {
        return $this->belongsToMany('App\Guitar', 'guitar_type');
    }
}
