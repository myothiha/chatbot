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

    const DEFAULT_BUTTON_TEXT = [
        "mm3" => "ရွေးချယ်ပါ",
        "zg" => "ေရြးခ်ယ္ပါ",
        "en" => "Choose"
    ];

    public function __construct(Answer $answer)
    {
        parent::__construct($answer);
    }

    function getAnswers($questionId = 0)
    {
        return $this->model->where(['question_id' => $questionId])->orderBy('created_at')->get();
    }

    function getVisibleAnswers($questionId = 0)
    {
        return $this->model->getAnswers($questionId)->visible();
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
        $answer->button_mm3 = $request->button_mm3 ?? self::DEFAULT_BUTTON_TEXT["mm3"];
        $answer->message_mm3 = $request->message_mm3;
        $answer->button_zg = $request->button_zg ?? self::DEFAULT_BUTTON_TEXT["zg"];
        $answer->message_zg = $request->message_zg;
        $answer->button_en = $request->button_en ?? self::DEFAULT_BUTTON_TEXT["en"];
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
        $answer->button_mm3 = $request->button_mm3 ?? self::DEFAULT_BUTTON_TEXT["mm3"];
        $answer->message_mm3 = $request->message_mm3;
        $answer->button_zg = $request->button_zg ?? self::DEFAULT_BUTTON_TEXT["zg"];
        $answer->message_zg = $request->message_zg;
        $answer->button_en = $request->button_en ?? self::DEFAULT_BUTTON_TEXT["en"];
        $answer->message_en = $request->message_en;
        $answer->image = $imagePath;
        $answer->status = $request->status;
        $answer->save();
        return $answer;
    }

    function delete(Answer $answer)
    {
        return $answer->delete();
    }

    public function prepare($questionId, $type, $lang)
    {
        $answers = $this->getVisibleAnswers($questionId)->get();
        return $this->transform($answers, $type, $lang);
    }
}
