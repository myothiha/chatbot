<?php

namespace App\Http\Controllers;

use App\Models\Answers\Answer;
use App\Models\Answers\Interfaces\AnswerRepositoryInterface;
use App\Models\AnswerTypes\AnswerType;
use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
use App\Models\Questions\Question;
use App\Services\Messenger\ApiConstant;
use Illuminate\Http\Request;

class AnswerController extends Controller
{

    private $answerRepository;

    public function __construct(AnswerRepositoryInterface $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $questionId
     * @return \Illuminate\Http\Response
     */
    public function index($questionId = 0)
    {
        /*$answers = Answer::find(['question_id' => $questionId]);
        $answerType = AnswerType::where('answer_id', $questionId)->first();

        $question = $this->questionRepository->get($questionId);

        return view('admin.answers.index', [
            'answers' => $answers,
            'question' => $question,
            'questionId' => $questionId,
            'types'     => ApiConstant::TYPES,
            'answerType' => $answerType->type ?? null,
        ]);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $questionId
     * @return \Illuminate\Http\Response
     */
    public function create($parentId)
    {
        $parentQuestion = Question::find($parentId);
        $parentQuestions = $parentQuestion ? $parentQuestion->getParentList()->reverse() : collect();
        return view('admin.answers.create', [
            'parentQuestions' => $parentQuestions,
            'questionId'    => $parentId,
            'types'         => ApiConstant::TYPES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $parentId)
    {
        $this->answerRepository->create($request, $parentId);

        return redirect("/questions/{$parentId}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $questionId
     * @param Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function edit($questionId, Answer $answer)
    {
        $parentQuestion = Question::find($questionId);
        $parentQuestions = $parentQuestion ? $parentQuestion->getParentList()->reverse() : collect();

        return view('admin.answers.edit', [
            'parentQuestions' => $parentQuestions,
            'answer'  => $answer,
            'questionId'  => $questionId,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $questionId
     * @param Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $questionId, Answer $answer)
    {
        $this->answerRepository->update($request, $questionId, $answer);
        return redirect("/questions/{$questionId}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($questionId, Answer $answer)
    {
        $this->answerRepository->delete($answer);
        return redirect("/questions/{$questionId}");
    }
}
