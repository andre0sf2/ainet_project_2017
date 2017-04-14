<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id', 'status', 'open_date', 'quantity', 'description','colored'
    ];

    public function printer()
    {
        return $this->belongsTo(Printer::class, 'printer_id');
    }

    public function owner()
    {
        return $this->belongsTo(Printer::class, 'owner_id');
    }
}
