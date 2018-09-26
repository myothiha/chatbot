<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'QuestionController@index');

Route::get('/webhook', 'ChatBotController@verify');
Route::post('/webhook', 'ChatBotController@handle');

//Route::resource('questions', 'QuestionController');

Route::get('/questions',                            'QuestionController@index');
Route::get('/questions/create/{parent_id}',          'QuestionController@create');
Route::post('/questions/{parent_id}',                'QuestionController@store');
Route::get('/questions/show/{parent_id}',            'QuestionController@show');
Route::get('/questions/{parent_id}/edit/{question}', 'QuestionController@edit');
Route::put('/questions/{parent_id}/update/{question}', 'QuestionController@update');
Route::delete('/questions/{parent_id}/delete/{question}', 'QuestionController@destroy');

Route::resource('answers', 'AnswerController');
Route::resource('answersDetail', 'AnswerDetailController');
