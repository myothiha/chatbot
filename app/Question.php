<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function scopeTop($query) {
        return $query->where('parent_id', '=', 0);
    }
}
