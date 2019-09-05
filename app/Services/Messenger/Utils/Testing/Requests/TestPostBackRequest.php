<?php
/**
 * Created by PhpStorm.
 * User: Myo Thiha
 * Date: 9/3/2019
 * Time: 11:50 AM
 */

namespace App\Services\Messenger\Utils\Testing\Requests;

class TestPostBackRequest extends TestRequest
{
    public function getRequestArray($payload, $title = 'test')
    {
        $postBack= [
            "title" => "{$title}",
            "payload" => "{$payload}",
        ];

        return $this->getRequestFormat("postback", $postBack);
    }
}