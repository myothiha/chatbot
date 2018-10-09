<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 9/30/2018
 * Time: 1:32 PM
 */

namespace App\Models\Questions\Interfaces;

use App\Models\Base\BaseRepositoryInterface;
use App\Models\Questions\Question;
use Illuminate\Http\Request;

interface QuestionRepositoryInterface extends BaseRepositoryInterface
{
    function getSubQuestions($parentId);
    function create(Request $request, $parentId);
    function update(Request $request, $parentId, Question $question);
    function delete(Question $question);
}
