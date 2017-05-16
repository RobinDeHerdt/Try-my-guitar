<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuitarImage extends Model
{
    /**
     * A guitar image belongs to a guitar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function guitar()
    {
        return $this->belongsTo('App\Guitar');
    }
}
