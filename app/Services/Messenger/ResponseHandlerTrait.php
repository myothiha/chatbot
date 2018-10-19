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

    public $defaultText = [
        ApiConstant::MYANMAR3   => "ရွေးချယ်ပါ",
        ApiConstant::ZAWGYI     => "ေရြးခ်ယ္ပါ",
        ApiConstant::ENGLISH    => "Choose",
    ];

    public function getDefaultText()
    {
        return $this->defaultText[$this->fbUser->language];
    }

    public function postBackButton(array $buttons, $text = null)
    {
        $data = [
            "recipient" => [
                "id" => $this->fbUser->psid
            ],
            "message" => [
                "attachment" => [
                    "type"      => "template",
                    "payload"   => [
                        "template_type" => "button",
                        "text"          => $text ?? $this->getDefaultText(),
                        "buttons"       => $buttons,
                    ],
                ],
            ],
        ];

        $this->sendRequest('POST', $data);
    }

    private function text($messages)
    {
        foreach ($messages as $message)
        {
            $data = [
                "recipient" => [
                    "id" => $this->fbUser->psid,
                ],
                "message" => [
                    "text" => $message
                ],
            ];

            $this->sendRequest('POST', $data);
        }
    }

    private function quickReply($messages, $text = null)
    {
        $data = [
            "recipient" => [
                "id" => $this->fbUser->psid,
            ],
            "message" => [
                "text" => $text ?? $this->getDefaultText(),
                "quick_replies" => $messages,
            ],
        ];

        $this->sendRequest('POST', $data);
    }

    private function image($messages)
    {
        foreach($messages as $message) {
            $data = [
                "recipient" => [
                    "id" => $this->fbUser->psid,
                ],
                "message" => [
                    "attachment" => [
                        "type"      => "image",
                        "payload"   => [
                            "url"           => $message,
                            "is_reusable"   => true
                        ],
                    ],
                ],
            ];

            $this->sendRequest('POST', $data);
        }
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
