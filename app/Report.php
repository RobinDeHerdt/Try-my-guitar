<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * A report belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function reporter()
    {
        return $this->belongsTo('App\User', 'reporter_id');
    }

    /**
     * A report belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function reported()
    {
        return $this->belongsTo('App\User', 'reported_id');
    }
}
