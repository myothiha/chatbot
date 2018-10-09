<?php

namespace App\Http\Controllers;

use App\Models\AnswerTypes\AnswerType;
use Illuminate\Http\Request;

class AnswerTypeController extends Controller
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
    public function store(Request $request, $questionId)
    {
        $answerType = AnswerType::firstOrNew(['answer_id' => $questionId]);
        $answerType->type = $request->type;
        $answerType->answer_id = $questionId;
        $answerType->save();
        return redirect('/answers/' . $questionId);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AnswerType  $answerType
     * @return \Illuminate\Http\Response
     */
    public function show(AnswerType $answerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AnswerType  $answerType
     * @return \Illuminate\Http\Response
     */
    public function edit(AnswerType $answerType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AnswerType  $answerType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnswerType $answerType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AnswerType  $answerType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnswerType $answerType)
    {
        //
    }
}
