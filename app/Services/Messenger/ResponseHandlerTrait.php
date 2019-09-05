<?php
/**
 * Created by PhpStorm.
 * User: myopc
 * Date: 10/15/2018
 * Time: 12:07 AM
 */

namespace App\Services\Messenger;


use App\FbUser;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

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

    public function getProfile()
    {
        $profile = $this->client->request("GET", "/{$this->fbUser->psid}", [
            'query'  => [
                'access_token'  => ApiConstant::ACCESS_TOKEN,
                'fields'        => 'id,name,first_name,last_name,profile_pic,locale,timezone,gender',
                'scrape'        => "true",
            ],
        ]);
        
        $data = $profile->getBody()->getContents();
        $this->fbUser->saveProfileData(json_decode($data));
    }

    public function multiplePostBack(array $messages)
    {
        $response = [];
        foreach ($messages as $message)
        {
            $response[] = $this->postBackButton([$message['button']], $message['text']);
        }

        return $response;
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

        return $this->sendRequest('POST', $data);
    }

    private function text($messages)
    {
        $response = [];
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

            $response[] = $data;

            $this->sendRequest('POST', $data);
        }
        return $response;
    }

    private function asyncText($messages)
    {

        $response = [];
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

            $response[] = $data;

            $this->sendAsyncRequest('POST', $data);
        }

        return $response;
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

        return $this->sendRequest('POST', $data);
    }

    private function image($messages)
    {

        $response = [];
        foreach($messages as $message) {
            $image = [
                "recipient" => [
                    "id" => $this->fbUser->psid,
                ],
                "message" => [
                    "attachment" => [
                        "type"      => "image",
                        "payload"   => [
                            "url"           => $message["image"],
                            "is_reusable"   => true,
                        ],
                    ],
                ],
            ];

            $this->sendRequest('POST', $image);

            $text = [
                "recipient" => [
                    "id" => $this->fbUser->psid,
                ],
                "message" => [
                    "text" => $message["text"],
                ],
            ];

            $response[] = [$image, $text];

            $this->sendRequest('POST', $text);
        }

        return $response;
    }

    private function gallery($messages)
    {
        $msgCollections = collect($messages);
        $response = [];
        foreach($msgCollections->chunk(10) as $messages) {
            $data = [
                "recipient" => [
                    "id" => $this->fbUser->psid,
                ],
                "message" => [
                    "attachment" => [
                        "type"      => "template",
                        "payload"   => [
                            "template_type" => "generic",
                            "elements" => $messages->toArray(),
                        ],
                    ],
                ],
            ];

            $response[] = $data;

            $this->sendRequest('POST', $data);
        }

        return $response;
    }

    public function senderAction($action) {
        $data = [
            "recipient" => [
                "id" => $this->fbUser->psid,
            ],
            "sender_action" => $action,
        ];

        $this->httpRequest('POST', $data);
    }

    private function sendRequest($requestType, $data)
    {
        $this->httpRequest($requestType, $data);
        return $data;
    }

    private function sendAsyncRequest($requestType, $data)
    {
        $this->httpAsyncRequest($requestType, $data);
    }

    private function httpRequest($requestType, $data)
    {
        $this->client->request($requestType, ApiConstant::MESSAGE, [
            'query'  => [
                'access_token' => ApiConstant::ACCESS_TOKEN,
                'scrape'        => "true",
            ],
            'json'  => $data,
        ]);
    }

    private function httpAsyncRequest($requestType, $data)
    {
        $promise = $this->client->requestAsync($requestType, ApiConstant::MESSAGE, [
            'query'  => [
                'access_token' => ApiConstant::ACCESS_TOKEN,
                'scrape'        => "true",
            ],
            'json'  => $data,
        ]);

        $promise->wait();
    }

}
