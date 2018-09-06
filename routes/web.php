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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/webhook', function (Request $request) {
//    dd($request->all());
    // Your verify token. Should be a random string.
    $VERIFY_TOKEN = "test_token";

    // Parse the query params
    $mode = $request->hub_mode;
    $token = $request->hub_verify_token;
    $challenge = $request->hub_challenge;

    // Checks if a token and mode is in the query string of the request
    if ($mode && $token) {
        // Checks the mode and token sent is correct
        if ($mode == "subscribe" && $token == $VERIFY_TOKEN) {
            // Responds with the challenge token from the request
//            echo 'WEBHOOK_VERIFIED';
            echo $challenge;
        }
    }
});

Route::post('/webhook', function (Request $request) {
//    dd($request->all());
    Log::debug($request->all());
    // Checks this is an event from a page subscription
    if ($request->object == 'page') {
        // Iterates over each entry - there may be multiple if batched
        foreach ($request->entry as $entry_item) {
            // Gets the message. entry.messaging is an array, but
            // will only ever contain one message, so we get index 0
            $webhook_event = $entry_item["messaging"][0]["message"];
            echo $webhook_event;
        }
    }
});

Route::post('/webhook', 'ChatbotController@handle');