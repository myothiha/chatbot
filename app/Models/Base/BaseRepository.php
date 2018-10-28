<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 9/30/2018
 * Time: 1:33 PM
 */

namespace App\Models\Base;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    protected $model;
    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }
}
