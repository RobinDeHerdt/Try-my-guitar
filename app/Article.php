<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The user that belongs to the article.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
