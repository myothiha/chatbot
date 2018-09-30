<?php

namespace App\Models\Questions\Repositories;

use App\Models\Base\BaseRepository;
use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
use App\Models\Questions\Question;
use App\Utils\Uploaders\ImageUploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{

    public function __construct(Question $question)
    {
        parent::__construct($question);
    }

    function getSubQuestions($parentId)
    {
        return Question::subQuestions($parentId)->get();
    }

    function create(Request $request, $parentId)
    {
        $imagePath = ImageUploader::upload($request->image, 'uploads/', Question::IMAGE_SCALE);

        $question = new Question();
        $question->parent_id = $parentId;
        $question->type = $request->type;
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
        $question->type = $request->type;
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

    function delete(Question $question)
    {
        return $question->delete();
    }
}
