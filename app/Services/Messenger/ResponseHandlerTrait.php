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

        $this->client->request('POST', ApiConstant::MESSAGE, [
            'query'  => ['access_token' => ApiConstant::ACCESS_TOKEN],
            'json'  => $data,
        ]);
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

    private function gallery($answers)
    {

    }
}
