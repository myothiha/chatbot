<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/8/2018
 * Time: 4:22 PM
 */

namespace App\Network\HttpClient;

use GuzzleHttp\Client;

class GuzzleHttp implements HttpClientInterface
{

    private $guzzleClient;

    public function __construct($baseUri, $timeout = 5.0) {
        $this->guzzleClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout'  => $timeout,
        ]);
    }

    public function request($method, $uri, $param =[]){
        $this->guzzleClient->request($method, $uri, $param);
    }
}
