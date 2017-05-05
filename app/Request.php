<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
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

    public function comment()
    {
        return $this->hasMany(Comment::class, 'request_id');
    }

    public function userClosed()
    {
        return $this->hasOne(User::class, 'closed_user_id');
    }
}
