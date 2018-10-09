<?php
/**
 * Created by PhpStorm.
 * User: myopc
 * Date: 10/8/2018
 * Time: 11:08 PM
 */

namespace App\Models\Answers\Interfaces;

use App\Models\Answers\Answer;
use Illuminate\Http\Request;

interface AnswerRepositoryInterface
{
    function getAnswers($questionId);
    function create(Request $request, $questionId);
    function update(Request $request, $questionId, Answer $answer);
    function delete(Answer $answer);
}
