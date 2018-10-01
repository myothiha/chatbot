<?php

namespace App\Http\Controllers;

use App\Models\QuestionTypes\QuestionType;
use Illuminate\Http\Request;

class QuestionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $parentId)
    {
        $questionType = new QuestionType();
        $questionType->type = $request->type;
        $request->question_id = $parentId;
        $questionType->save();
        return redirect('/questions/' . $parentId);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionTypes\QuestionType  $questionType
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionType $questionType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionTypes\QuestionType  $questionType
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionType $questionType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionTypes\QuestionType  $questionType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionType $questionType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionTypes\QuestionType  $questionType
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionType $questionType)
    {
        //
    }
}
