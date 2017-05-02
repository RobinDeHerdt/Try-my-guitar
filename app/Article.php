<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * The user that belongs to the article.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
