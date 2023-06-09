<?php
/**
 * Created by PhpStorm.
 * User: myopc
 * Date: 10/8/2018
 * Time: 8:50 PM
 */

namespace App\Services\Messenger;


use Illuminate\Http\Request;

trait RequestHandlerTrait
{

    private function getTextMessage(Request $request)
    {
        // Iterates over each entry - there may be multiple if batched
        /*foreach ($request->entry as $entry_item) {
            // Gets the message. entry.messaging is an array, but
            // will only ever contain one message, so we get index 0
            $message = $entry_item["messaging"][0]["message"];
        }*/
        return $request['entry'][0]["messaging"][0]["message"]["text"] ?? false;
    }

    private function getPayLoad(Request $request)
    {
        return ($this->getPostbackPayload($request) ?? $this->quickReplyPayload($request)) ?? false;
    }

    private function getPostbackPayload(Request $request)
    {
        return $request['entry'][0]['messaging'][0]['postback']['payload'] ?? null;
    }

    private function quickReplyPayload(Request $request)
    {
        return $request['entry'][0]['messaging'][0]['message']['quick_reply']['payload'] ?? null;
    }

    private function getSenderId(Request $request)
    {
        return $request['entry'][0]['messaging'][0]['sender']['id'] ?? null;
    }
}
