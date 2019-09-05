<?php
/**
 * Created by PhpStorm.
 * User: Myo Thiha
 * Date: 9/3/2019
 * Time: 11:50 AM
 */

namespace App\Services\Messenger\Requests;

class PostBackRequest extends MessengerRequest
{
    public function testRequest($title = "Testing", $payload)
    {
        return [
            "object" => "page",
            "entry" => [
                [
                    "id" => "{$this->pageId}",
                    "time" => 1458692752478,
                    "messaging" => [
                        [
                            "sender" => [
                                "id" => "{$this->psId}"
                            ],
                            "recipient" => [
                                "id" => "{$this->pageId}"
                            ],
                            "timestamp" => 1458692752478,
                            "postback" => [
                                "title" => "{$title}",
                                "payload" => "{$payload}",
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    function getRawArray()
    {
        // TODO: Implement getRawArray() method.
    }
}