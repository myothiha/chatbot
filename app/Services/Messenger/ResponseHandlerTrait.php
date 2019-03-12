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
//        dd(json_decode($data));
        $this->fbUser->saveProfileData(json_decode($data));
    }

    public function multiplePostBack(array $messages)
    {
        foreach ($messages as $message)
        {
            $this->postBackButton([$message['button']], $message['text']);
        }
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

    private function asyncText($messages)
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

            $this->sendAsyncRequest('POST', $data);
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

            $this->sendRequest('POST', $text);
        }
    }

    private function gallery($messages)
    {
        $msgCollections = collect($messages);

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

            $this->sendRequest('POST', $data);
        }
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
        $this->senderAction('typing_on');
        sleep(1);

        $this->httpRequest($requestType, $data);
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
