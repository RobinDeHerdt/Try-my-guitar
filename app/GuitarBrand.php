<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuitarBrand extends Model
{
    /**
     * A guitar brand has many guitars.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function guitars()
    {
        return $this->hasMany('App\Guitar', 'brand_id');
    }
}
