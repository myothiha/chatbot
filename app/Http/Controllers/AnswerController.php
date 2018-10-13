<?php

namespace App\Http\Controllers;

use App\Models\Answers\Answer;
use App\Models\Answers\Interfaces\AnswerRepositoryInterface;
use App\Models\AnswerTypes\AnswerType;
use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
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

        return view('admin.answers.create', [
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
