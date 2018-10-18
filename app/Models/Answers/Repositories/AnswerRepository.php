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
use App\Models\Messenger\MessengerApi;
use App\Utils\Uploaders\ImageUploader;
use Illuminate\Http\Request;

class AnswerRepository extends MessengerApi implements AnswerRepositoryInterface
{

    public function __construct(Answer $answer)
    {
        parent::__construct($answer);
    }

    function getAnswers($questionId)
    {
        return $this->model->where(['question_id' => $questionId])->get();
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
        $answer->traceAId = $request->traceAId;
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
        if ($request->file('image')) {
            $answer->deleteImages();
            $imagePath = ImageUploader::upload($request->image, 'uploads/', Answer::IMAGE_SCALE);
        } else {
            $imagePath = $request->prev_image;
        }

        $answer->question_id = $questionId;
        $answer->traceAId = $request->traceAId;
        $answer->button_mm3 = $request->button_mm3;
        $answer->message_mm3 = $request->message_mm3;
        $answer->button_zg = $request->button_zg;
        $answer->message_zg = $request->message_zg;
        $answer->button_en = $request->button_en;
        $answer->message_en = $request->message_en;
        $answer->image = $imagePath;
        $answer->status = $request->status;
        $answer->save();
        return $answer;
    }

    function delete(Answer $answer)
    {
        // TODO: Implement delete() method.
    }

    public function prepare($questionId, $type, $lang)
    {
        $answers = $this->getAnswers($questionId);
        return $this->transform($answers, $type, $lang);
    }
}
