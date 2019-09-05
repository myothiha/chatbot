<?php
/**
 * Created by PhpStorm.
 * User: Myo Thiha
 * Date: 9/3/2019
 * Time: 3:10 PM
 */

namespace App\Services\Messenger\Requests;


abstract class MessengerRequest
{

    function requestType($webHookArray) {
        return array_push($this->requestFormat["messaging"][0], $webHookArray);
    }

    abstract function getRawArray();

}