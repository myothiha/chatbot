<?php

namespace App\Models\Questions;

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

    /**
     * @return string
     */
    public function getLargeImageAttribute()
    {
        return "/uploads/large/{$this->image}";
    }

    /**
     * @return string
     */
    public function getThumbnailAttribute()
    {
        return "/uploads/small/{$this->image}";
    }

    /**
     *
     */
    public function deleteImages()
    {
        if (file_exists(public_path() . $this->largeImage) ) {
            unlink(public_path() . $this->largeImage);
            unlink(public_path() . $this->thumbnail);
        }
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        $this->deleteImages();
        return parent::delete();
    }

}
