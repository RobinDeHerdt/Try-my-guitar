<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /**
     * An experience belongs to a guitar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function guitar()
    {
        return $this->belongsTo('App\Guitar');
    }

    /**
     * An experience belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * An experience has many votes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    /**
     * An experience has many upvotes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function upVotes()
    {
        return $this->hasMany('App\Vote')->where('value', 1);
    }

    /**
     * An experience has many downvotes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function downVotes()
    {
        return $this->hasMany('App\Vote')->where('value', 0);
    }
}
