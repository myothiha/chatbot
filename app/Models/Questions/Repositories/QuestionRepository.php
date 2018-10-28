<?php

namespace App\Models\Questions\Repositories;

use App\Models\Answers\Answer;
use App\Models\Messenger\MessengerApi;
use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
use App\Models\Questions\Question;
use App\Services\Messenger\ApiConstant;
use App\Utils\Uploaders\ImageUploader;
use Illuminate\Http\Request;

class QuestionRepository extends MessengerApi implements QuestionRepositoryInterface
{

    public function __construct(Question $question)
    {
        parent::__construct($question);
    }

    function getSubQuestions($parentId)
    {
        return Question::subQuestions($parentId)->get();
    }

    function get($questionId)
    {
        return Question::find($questionId);
    }

    function create(Request $request, $parentId)
    {
        if ($request->file('image')) {
            $imagePath = ImageUploader::upload($request->image, 'uploads/', Answer::IMAGE_SCALE);
        } else {
            $imagePath = null;
        }

        $question = new Question();
        $question->parent_id = $parentId;
        $question->traceQId = $request->traceQId;
        $question->tracePId = $request->tracePId;
        $question->button_mm3 = $request->button_mm3;
        $question->message_mm3 = $request->message_mm3;
        $question->button_zg = $request->button_zg;
        $question->message_zg = $request->message_zg;
        $question->button_en = $request->button_en;
        $question->message_en = $request->message_en;
        $question->image = $imagePath;
        $question->save();

        return $question;
    }

    function update(Request $request, $parentId, Question $question)
    {
        if ($request->file('image')) {
            $question->deleteImages();
            $imagePath = ImageUploader::upload($request->image, 'uploads/', Question::IMAGE_SCALE);
        } else {
            $imagePath = $request->prev_image;
        }

        $question->parent_id = $parentId;
        $question->traceQId = $request->traceQId;
        $question->tracePId = $request->tracePId;
        $question->button_mm3 = $request->button_mm3;
        $question->message_mm3 = $request->message_mm3;
        $question->button_zg = $request->button_zg;
        $question->message_zg = $request->message_zg;
        $question->button_en = $request->button_en;
        $question->message_en = $request->message_en;
        $question->image = $imagePath;
        $question->status = $request->status;
        $question->save();
//        dd($question->toArray()); Todo remove
        return $question;
    }

    public function prepare($questionId, $type, $lang)
    {
        $subQuestions = $this->getSubQuestions($questionId);

        return $this->transform($subQuestions, $type, $lang);
    }

    function delete(Question $question)
    {
        return $question->delete();
    }

    function search($keyword, $lang)
    {
        $result = collect([]);
        switch ($lang) {
            case ApiConstant::ZAWGYI :
                $result = $this->model->searchMessage($keyword, "message_zg");
                break;
            case ApiConstant::MYANMAR3 :
                $result = $this->model->searchMessage($keyword, "message_mm3");
                break;
            case ApiConstant::ENGLISH :
                $result = $this->model->searchMessage($keyword, "message_en");
                break;
        }

        return $result->visible()->get();
    }
}
