<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * A comment belongs to an article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comment()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * A comment belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
