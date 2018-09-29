<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::top()->get();
        return view('admin.questions.index', [
            'questions' => $questions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($parentId)
    {
        return view('admin.questions.create', [
            'parentId'  => $parentId,
            'types'     => Question::TYPES,
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
//        dd($request->all());
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
        $question->image = $request->image;
        $question->save();
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
