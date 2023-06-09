<?php

namespace App\Models\Questions;

use App\Models\Base\BaseModel;
use App\Models\Messenger\Interfaces\MessengerApiInterface;
use App\Services\Messenger\ApiConstant;

/**
 * Class Question
 * @package App\Models\Questions
 */
class Question extends BaseModel implements MessengerApiInterface
{

    /**
     * Image Upload Scale
     */
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

    public function parent()
    {
        return $this->belongsTo('App\Models\Questions\Question', 'parent_id');
    }

    public function scopeGetSubQuestions($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    public function getParentList()
    {
        $collection = collect([]);
        $question = $this;
        while ($question) {
            $collection->push($question);
            $question = $question->parent;
        }
        return $collection;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeTop($query)
    {
        return $query->where('parent_id', 0);
    }

    /**
     * @param $query
     * @param $parentId
     * @return mixed
     */
    public function scopeSubQuestions($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    /*public function getImageAttribute($value)
    {
        return $value ?? $this->defaultImage;
    }*/

    function message($lang)
    {
        switch ($lang) {
            case ApiConstant::MYANMAR3 :
                return $this->message_mm3 ?? "";
                break;
            case ApiConstant::ZAWGYI :
                return $this->message_zg ?? "";
                break;
            case ApiConstant::ENGLISH :
                return $this->message_en ?? "";
                break;
        }
    }

    function button($lang)
    {
        switch ($lang) {
            case ApiConstant::MYANMAR3 :
                return $this->button_mm3 ?? "";
                break;
            case ApiConstant::ZAWGYI :
                return $this->button_zg ?? "";
                break;
            case ApiConstant::ENGLISH :
                return $this->button_en ?? "";
                break;
        }
    }
}
