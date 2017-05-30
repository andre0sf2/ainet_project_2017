<?php

namespace App;

use Carbon\Carbon;
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
            //$cont += count($user->requests);
            foreach ($user->requests as $request){
                if ($request->status == 2){
                    $cont++;
                }
            }
        }

        return $cont;
    }
}
