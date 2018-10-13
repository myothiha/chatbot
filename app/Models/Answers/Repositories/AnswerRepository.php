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
use App\Utils\Uploaders\ImageUploader;
use Illuminate\Http\Request;

class AnswerRepository extends BaseRepository implements AnswerRepositoryInterface
{

    public function __construct(Answer $answer)
    {
        parent::__construct($answer);
    }

    function getAnswers($questionId)
    {
        return $this->model->find(['question_id' => $questionId]);
    }

    function create(Request $request, $questionId)
    {
        if ($request->file('image')) {
            $imagePath = ImageUploader::upload($request->image, 'uploads/', Answer::IMAGE_SCALE);
        } else {
            $imagePath = null;
        }

        $answer = new Answer();
        $answer->question_id = $questionId;
        $answer->traceAId = $request->traceQId;
        $answer->button_mm3 = $request->button_mm3;
        $answer->message_mm3 = $request->message_mm3;
        $answer->button_zg = $request->button_zg;
        $answer->message_zg = $request->message_zg;
        $answer->button_en = $request->button_en;
        $answer->message_en = $request->message_en;
        $answer->status = $request->type;
        $answer->image = $imagePath;
        $answer->save();

        return $answer;
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
