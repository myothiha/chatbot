<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'message'
    ];

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
