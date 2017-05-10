<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
     * A user has many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
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
