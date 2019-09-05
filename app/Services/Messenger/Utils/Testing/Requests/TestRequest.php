<?php
/**
 * Created by PhpStorm.
 * User: Myo Thiha
 * Date: 9/3/2019
 * Time: 11:50 AM
 */

namespace App\Services\Messenger\Utils\Testing\Requests;

abstract class TestRequest
{
    protected $psId;
    protected $pageId;
    protected $requestFormat;

    /**
     * Request constructor.
     * @param $psId
     * @param $pageId
     */
    public
    function __construct($psId = 2124075904329655, $pageId = 422359484916418)
    {
        $this->psId = $psId;
        $this->pageId = $pageId;
    }

    function getRequestFormat($webHookEvent, $data) {

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
                            $webHookEvent => $data,
                        ]
                    ]
                ]
            ]
        ];
    }
}