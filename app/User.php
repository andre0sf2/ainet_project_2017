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
        'name', 'email', 'phone','password', 'profile_photo', 'profile_url','department_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->admin == 1 ? true : false;
    }

    public function isBlocked()
    {
        return $this->blocked == 1 ? true : false;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'owner_id');
    }
}
