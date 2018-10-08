<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/8/2018
 * Time: 4:22 PM
 */

namespace App\Network\HttpClient;


class GuzzleHttp implements HttpClientInterface
{
    public function __construct($baseUri, $timeout = 5.0) {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout'  => $timeout,
        ]);
    }
}
