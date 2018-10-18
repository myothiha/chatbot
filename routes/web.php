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

Route::get('/questions/{parentId?}',                        'QuestionController@index');
Route::get('/questions/{parentId}/create',                  'QuestionController@create');
Route::post('/questions/{parentId}',                        'QuestionController@store');
Route::get('/questions/show/{parentId}',                    'QuestionController@show');
Route::get('/questions/{parentId}/edit/{question}',         'QuestionController@edit');
Route::put('/questions/{parentId}/update/{question}',       'QuestionController@update');
Route::delete('/questions/{parentId}/delete/{question}',    'QuestionController@destroy');

Route::post('/questionTypes/{parentId}',                  'QuestionTypeController@store');

Route::get('/answers/{questionId?}',                      'AnswerController@index');
Route::get('/answers/{questionId}/create',                'AnswerController@create');
Route::post('/answers/{questionId}',                      'AnswerController@store');
Route::get('/answers/show/{questionId}',                  'AnswerController@show');
Route::get('/answers/{questionId}/edit/{answer}',         'AnswerController@edit');
Route::put('/answers/{questionId}/update/{answer}',       'AnswerController@update');
Route::delete('/answers/{questionId}/delete/{answer}',    'AnswerController@destroy');

Route::post('/answerTypes/{questionId}', 'AnswerTypeController@store');

//Route::resource('answersDetail', 'AnswerDetailController');

Route::get('/test/{lang}/', 'ChatBotController@response');
