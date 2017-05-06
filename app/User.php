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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * The articles that belong to the user.
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * A user has many messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    /**
     * The channels that belong to the user.
     */
    public function channels()
    {
        return $this->belongsToMany('App\Channel');
    }

    /**
     * Check if the user has the administrator role.
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
