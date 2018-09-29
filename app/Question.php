<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    const TEXT = 1;
    const QUICK_REPLY = 2;
    const BUTTON = 3;
    const IMAGE = 4;
    const GALLERY = 5;

    const TYPES = [
        self::TEXT          => 'Text',
        self::QUICK_REPLY   => 'Quick Reply',
        self::BUTTON        => 'Button',
        self::IMAGE         => 'Image',
        self::GALLERY       => 'Gallery',
    ];

    public function scopeTop($query)
    {
        return $query->where('parent_id', '=', 0);
    }
}
