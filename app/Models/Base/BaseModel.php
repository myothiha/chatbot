<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 9/30/2018
 * Time: 1:33 PM
 */

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

abstract class BaseModel extends Model
{

    const VISIBILITY_TRUE = 1;

    const VISIBILITY_FALSE = 0;

    private $defaultImage = "default.png";

    protected function getDefaultImageAttribute()
    {
        return $this->defaultImage;
    }

    protected function setDefaultImageAttribute($value)
    {
        $this->defaultImage = $value;
    }

    public function  apiImageSmall()
    {
        return Request::root() . $this->thumbnail;
    }

    public function  apiImageLarge()
    {
        return Request::root() . $this->largeImage;
    }

    /**
     * @return string
     */
    public function getLargeImageAttribute()
    {
        return "/uploads/large/" . ($this->image ?? $this->defaultImage);
    }

    /**
     * @return string
     */
    public function getThumbnailAttribute()
    {
        return "/uploads/small/" . ($this->image ?? $this->defaultImage);
    }

    /**
     *
     */
    public function deleteImages()
    {
//        dd($this->image ?? 'a');
        if (file_exists(public_path() . $this->largeImage) AND isset($this->image) ) {
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

    public function scopeVisible($query)
    {
        return $query->where('status', self::VISIBILITY_TRUE);
    }

    public function scopeSearchMessage($query, $keyword, $column)
    {
        return $query->where($column, 'like', "%{$keyword}%");
    }
}
