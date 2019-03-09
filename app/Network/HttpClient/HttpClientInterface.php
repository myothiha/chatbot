<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/8/2018
 * Time: 4:21 PM
 */

namespace App\Network\HttpClient;


interface HttpClientInterface
{
    function request($method, $uri, $param);
    function requestAsync($method, $uri, $param);
}
