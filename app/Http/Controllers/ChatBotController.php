<?php

namespace App\Http\Controllers;

use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\ChatBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatBotController extends Controller
{

    const URL = "https://graph.facebook.com/v2.6/me/messages";

    private $chatbot;

    public function __construct(ChatBot $chatBot)
    {
        $this->chatbot = $chatBot;
    }

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

        $senderId = $this->getSenderId($request);

        // Checks this is an event from a page subscription
        if ($request->object == 'page') {
            if( $message = $this->getTextMessage($request) )
            {

            }
            elseif ( $payload = $this->getPayload($request) )
            {
                if( $payload == "start" ) {
                    $this->chooseLanguage($senderId);
                }
            }

            // just to verify web hook
            echo $this->getTextMessage($request);
        }
    }

    private function chooseLanguage($senderId) {

        $buttons = [
            [
                "type"      => "postback",
                "title"     => "ျမန္မာ (ေဇာ္ဂ်ီ)",
                "payload"   => ApiConstant::ZAWGYI,
            ],
            [
                "type"      => "postback",
                "title"     => "မြန်မာ (ယူနီကုဒ်)",
                "payload"   => ApiConstant::MYANMAR3,
            ],
            [
                "type"      => "postback",
                "title"     => "English",
                "payload"   => ApiConstant::ENGLISH,
            ],
        ];

        $this->chatbot->postBackButton($senderId, "Choose Language.", $buttons);
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

    private function getPayload(Request $request)
    {
        return $request['entry'][0]['messaging'][0]['postback']['payload'];
    }

    private function getSenderId(Request $request)
    {
        return $request['entry'][0]['messaging'][0]['sender']['id'];
    }
}
