<?php

namespace App\Models\Answers;

use App\Models\Base\BaseModel;
use App\Models\Messenger\Interfaces\MessengerApiInterface;
use App\Services\Messenger\ApiConstant;

class Answer extends BaseModel implements MessengerApiInterface
{

    const IMAGE_SCALE = [
        'small' => [
            'width' => '720',
            'height' => '460'
        ],
        'large' => [
            'width' => '1920',
            'height' => '1080'
        ],
    ];

    public function scopeGetAnswers($query, $questionId)
    {
        return $query->where('question_id', $questionId);
    }

    public function question()
    {
        return $this->belongsTo('App\Models\Questions\Question', 'question_id');
    }

    function message($lang)
    {
        switch ($lang)
        {
            case ApiConstant::MYANMAR3 :
                return $this->message_mm3;
                break;
            case ApiConstant::ZAWGYI :
                return $this->message_zg;
                break;
            case ApiConstant::ENGLISH :
                return $this->message_en;
                break;
        }
    }

    function button($lang)
    {
        switch ($lang)
        {
            case ApiConstant::MYANMAR3 :
                return $this->message_mm3;
                break;
            case ApiConstant::ZAWGYI :
                return $this->message_zg;
                break;
            case ApiConstant::ENGLISH :
                return $this->message_en;
                break;
        }
    }
}
