<?php

namespace App\Models\Questions;

use App\Models\Base\BaseModel;

/**
 * Class Question
 * @package App\Models\Questions
 */
class Question extends BaseModel
{

    /**
     * Image Upload Scale
     */
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

}
