<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/8/2018
 * Time: 4:17 PM
 */

namespace App\Services\Messenger;

use App\Network\HttpClient\GuzzleHttp;

class ChatBot
{
    private $client;

    public function __construct() {
        $this->client = new GuzzleHttp(ApiConstant::BASE_URL);
    }

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

        $this->client->request('POST', '/', [
           'query'  => ['access_token' => ApiConstant::ACCESS_TOKEN],
            'json'  => $data,
        ]);
    }
}
