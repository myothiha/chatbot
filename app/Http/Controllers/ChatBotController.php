<?php

namespace App\Http\Controllers;

use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\ChatBot;
use App\Services\Messenger\RequestHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatBotController extends Controller
{

    use RequestHandlerTrait;

    private $chatBot;

    public function __construct(ChatBot $chatBot)
    {
        $this->chatBot = $chatBot;
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

            if ( $payload = $this->getPayload($request) )
            {
                if( $payload == "start" ) {
                    $this->askToChooseLanguage($senderId);
                } else {

                }
            }

            // just to verify web hook
            echo $this->getTextMessage($request);
        }
    }

    private function askToChooseLanguage($senderId) {

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

        $this->chatBot->postBackButton($senderId, "Choose Language.", $buttons);
    }
}
