<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Department extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function countPrints()
    {
        $cont = 0;
        foreach ($this->users as $user){
            $cont += count($user->requests);
        }
        return $cont;
    }

}
