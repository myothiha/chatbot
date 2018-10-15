<?php
/**
 * Created by PhpStorm.
 * User: myopc
 * Date: 10/15/2018
 * Time: 12:07 AM
 */

namespace App\Services\Messenger;


trait ResponseHandlerTrait
{
    public function postBackButton($psid, $text, array $buttons)
    {
        $data = [
            "recipient" => [
                "id" => $psid
            ],
            "message" => [
                "attachment" => [
                    "type"      => "template",
                    "payload"   => [
                        "template_type" => "button",
                        "text"          => $text,
                        "buttons"       => $buttons,
                    ],
                ],
            ],
        ];

        $this->sendRequest('POST', $data);
    }

    private function text($answers)
    {

    }

    private function quickReply($answers)
    {

    }

    private function button($answers)
    {

    }

    private function image($answers)
    {

    }

    private function gallery($messages)
    {
        $data = [
            "recipient" => [
                "id" => $this->fbUser->psid,
            ],
            "message" => [
                "attachment" => [
                    "type"      => "template",
                    "payload"   => [
                        "template_type" => "generic",
                        "elements" => $messages,
                    ],
                ],
            ],
        ];

        $this->sendRequest('POST', $data);
    }

    private function sendRequest($requestType, $data)
    {
        $this->client->request($requestType, ApiConstant::MESSAGE, [
            'query'  => ['access_token' => ApiConstant::ACCESS_TOKEN],
            'json'  => $data,
        ]);
    }
}
