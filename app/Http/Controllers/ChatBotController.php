<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatBotController extends Controller
{

    const URL = "https://graph.facebook.com/v2.6/me/messages";
    const ACCESS_TOKEN = "EAAgS93j7IooBABeFFZCXgRXIRkTrWMHmonrccFTwLs4m2drPznDweU5gqesue1qZCADJ0E8ZBh3hwlePq6aBIrHdVB3qzvAJytimM6JW2CjaQxSfGyIWaJpkDaafb0QmTs6Gl8yjyjHbZANN0Fg9gY598qkI30OlZCpTOxZCeHjYE9aL8mnW40";

    public function verify(Request $request)
    {
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
                echo $challenge;
            }
        }
    }

    public function handle(Request $request)
    {
        Log::debug($request->all());

        // Checks this is an event from a page subscription
        if ($request->object == 'page') {
            if( $message = $this->getTextMessage($request) )
            {

            }

            // just to verify web hook
            echo $this->getTextMessage($request);
        }
    }

    private function getTextMessage(Request $request)
    {
        // Iterates over each entry - there may be multiple if batched
        /*foreach ($request->entry as $entry_item) {
            // Gets the message. entry.messaging is an array, but
            // will only ever contain one message, so we get index 0
            $message = $entry_item["messaging"][0]["message"];
        }*/
        return $request['entry'][0]["messaging"][0]["message"];
    }

    private function senderId(Request $request)
    {
        return $request['entry'][0]['messaging'][0]['sender']['id'];
    }
}
