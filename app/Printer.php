<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function requests()
    {
        return $this->hasMany(Request::class, 'printer_id');
    }
}
