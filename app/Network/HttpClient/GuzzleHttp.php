<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/8/2018
 * Time: 4:22 PM
 */

namespace App\Network\HttpClient;

use App\Services\Messenger\ApiConstant;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class GuzzleHttp implements HttpClientInterface
{

    private $guzzleClient;

    public function __construct($baseUri, $timeout = 10.0)
    {
        $this->guzzleClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout' => $timeout,
        ]);
    }

    /**
     * @param $method
     * @param $uri
     * @param array $param
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    public function request($method, $uri, $param = [])
    {
        return $this->guzzleClient->request($method, $uri, $param);
    }

    /**
     * @param $method
     * @param $uri
     * @param array $param
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function requestAsync($method, $uri, $param = [])
    {
        Log::debug('bbbbb');
        return $this->guzzleClient->requestAsync($method, $uri, $param);
    }
}
