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
        'owner_id',
        'status',
        'open_date',
        'due_date',
        'quantity',
        'description',
        'colored',
        'paper_type',
        'paper_size',
        'file',
        'closed_date',
        'refused_reason',
        'satisfaction_grade',
        'stapled',
        'front_back',
        'printer_id',
        'closed_user_id'
    ];

    public function statusToStr()
    {
        switch ($this->status) {
            case 0:
                return 'Open';
            case 1:
                return 'Refuse';
            case 2:
                return 'Complete';
            case 3:
                return 'Expired';
        }

        return 'Unknown';
    }

    public function paperTypeToStr()
    {
        switch ($this->paper_type) {
            case 0:
                return 'Draft';
            case 1:
                return 'Normal';
            case 2:
                return 'Photo';
        }

        return 'Unknown';
    }

    public function paperSizeToStr()
    {
        if($this->paper_size)
            return 'A'.$this->paper_size;

        return 'Unknown';
    }

    public function printer()
    {
        return $this->belongsTo(Printer::class, 'printer_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'request_id');
    }

    public function userClosed()
    {
        return $this->hasOne(User::class, 'closed_user_id');
    }
}
