<?php
/**
 * Created by PhpStorm.
 * User: myopc
 * Date: 10/8/2018
 * Time: 11:11 PM
 */

namespace App\Models\Answers\Repositories;


use App\Models\Answers\Answer;
use App\Models\Answers\Interfaces\AnswerRepositoryInterface;
use App\Models\Base\BaseRepository;
use Illuminate\Http\Request;

class AnswerRepository extends BaseRepository implements AnswerRepositoryInterface
{

    public function __construct(Answer $answer)
    {
        parent::__construct($answer);
    }

    function getAnswers($questionId)
    {
//        return $this->model->find(['question_id' => $questionId]);
    }

    function create(Request $request, $questionId)
    {
        // TODO: Implement create() method.
    }

    function update(Request $request, $questionId, Answer $answer)
    {
        // TODO: Implement update() method.
    }

    function delete(Answer $answer)
    {
        // TODO: Implement delete() method.
    }
}
