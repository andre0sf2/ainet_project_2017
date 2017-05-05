<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['parent_id', 'user_id', 'comment', 'request_id'];

    public function owner()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function requests()
    {
        $this->belongsTo(Request::class, 'request_id');
    }
}
