<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'verified',
        'verification_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * A user belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * A user has many articles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * A user has many reports.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function receivedReports()
    {
        return $this->hasMany('App\Report', 'reported_id');
    }

    /**
     * A user has many reports.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function sentReports()
    {
        return $this->hasMany('App\Report', 'reporter_id');
    }

    /**
     * A user has many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    /**
     * A user belongs to many guitars.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function guitars()
    {
        return $this->belongsToMany('App\Guitar', 'user_guitar');
    }

    /**
     * A user belongs to many guitars.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function profileShowGuitars()
    {
        return $this->belongsToMany('App\Guitar', 'user_guitar')->wherePivot('profile_show', true);
    }

    /**
     * A user has many invites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentInvites()
    {
        return $this->hasMany('App\Invite', 'sender_id');
    }

    /**
     * A user has many invites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivedInvites()
    {
        return $this->hasMany('App\Invite', 'receiver_id');
    }

    /**
     * A user belongs to many channels.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function channels()
    {
        return $this->belongsToMany('App\Channel');
    }


    /**
     * A user has many guitar images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function guitarImages()
    {
        return $this->hasMany('App\GuitarImage');
    }

    /**
     * A user has many votes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    /**
     * A user has many experiences.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function experiences()
    {
        return $this->hasMany('App\Experience');
    }

    /**
     * A user has many comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Check if the user has entered an experience for the specified guitar.
     *
     * @param Guitar  $guitar
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function guitarExperience(Guitar $guitar)
    {
        return $guitar->experiences()->where('user_id', $this->id)->first();
    }

    /**
     * Returns the full user name.
     *
     * @return string
     */
    public function fullName()
    {
        if (isset($this->last_name)) {
            return $this->first_name . ' ' . $this->last_name;
        } else {
            return $this->first_name;
        }
    }

    /**
     * Add the user to a channel and set the 'not accepted' status.
     */
    public function addUnacceptedUserToChannel($channel_id)
    {
        $this->channels()->attach($channel_id, ['accepted' => false]);
    }

    /**
     * Add the user to a channel and set the 'accepted' status.
     */
    public function addAcceptedUserToChannel($channel_id)
    {
        $this->channels()->attach($channel_id, ['accepted' => true]);
    }

    /**
     * Set the 'accepted' status for the user, who was already added to the channeL.
     */
    public function acceptUserToChannel($channel_id)
    {
        $this->channels()->updateExistingPivot($channel_id, ['accepted' => true]);
    }

    /**
     * Remove the user from the specified channel.
     */
    public function removeUserFromChannel($channel_id)
    {
        $this->channels()->detach($channel_id);
    }

    /**
     * Set the user status to 'seen' for the specified channel.
     */
    public function setChannelSeen($channel_id)
    {
        $this->channels()->updateExistingPivot($channel_id, ['seen' => true]);
    }

    /**
     * Set the user status to 'unseen' for the specified channel.
     */
    public function setChannelNotSeen($channel_id)
    {
        $this->channels()->updateExistingPivot($channel_id, ['seen' => false]);
    }

    /**
     * Remove the user's invites for the specified channel.
     */
    public function removeChannelInvites($channel_id)
    {
        $this->receivedInvites()->where('channel_id', $channel_id)->delete();
    }

    /**
     * Check if the authenticated user has the specified role.
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        $user_roles = $this->roles()->get();

        foreach ($user_roles as $user_role) {
            if ($user_role->name === $role) {
                return true;
            }
        }
        return false;
    }
}
