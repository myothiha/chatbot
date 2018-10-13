<?php

namespace App\Models\Answers;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    const IMAGE_SCALE = [
        'small' => [
            'width' => '300',
            'height' => '140'
        ],
        'large' => [
            'width' => '500',
            'height' => '260'
        ],
    ];

    public function question()
    {
        return $this->belongsTo('App\Question', 'question_id');
    }

}
