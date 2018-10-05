<?php

namespace App\Http\Controllers;

use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
use App\Models\Questions\Question;
use App\Models\QuestionTypes\QuestionType;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    private $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $parentId
     * @return \Illuminate\Http\Response
     */
    public function index($parentId = 0)
    {
        $questions = $this->questionRepository->getSubQuestions($parentId);
        $questionType = QuestionType::where('question_id', $parentId)->first();
//        dd($questionType->toArray());
        return view('admin.questions.index', [
            'questions' => $questions,
            'parentId' => $parentId,
            'questionType' => $questionType->type ?? null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $parentId
     * @return \Illuminate\Http\Response
     */
    public function create($parentId)
    {
        return view('admin.questions.create', [
            'parentId' => $parentId,
            'types' => Question::TYPES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $parentId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $parentId)
    {
        $this->questionRepository->create($request, $parentId);

        return redirect("/questions/{$parentId}");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $parentId
     * @param Question $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($parentId, Question $question)
    {
//        dd($question->toArray()); //Todo remove
        return view('admin.questions.edit', [
            'question'  => $question,
            'parentId'  => $parentId,
            'types'     => Question::TYPES,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $parentId
     * @param Question $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, $parentId, Question $question)
    {
        $this->questionRepository->update($request, $parentId, $question);
        return redirect("/questions/{$parentId}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $parentId
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($parentId, Question $question)
    {
        $this->questionRepository->delete($question);
        return redirect("/questions/{$parentId}");
    }
}