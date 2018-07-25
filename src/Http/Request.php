<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/23
 * Time: 15:17
 */

namespace Zamseam\Mixin\Http;

use GuzzleHttp\Client;
use Zamseam\Mixin\Encrypt\AuthToken;
use Ramsey\Uuid\Uuid;

//use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
//use GuzzleHttp\TransferStats;

class Request
{
    private $guzzle;
    private $method;
    private $uri;
    protected $userInfo;
    private $body = "";
    private $headers = [];
    private $baseApi;
    private $token = "";

    public function __construct($userInfo, $baseApi)
    {
        $this->userInfo = $userInfo;
        $this->baseApi = $baseApi;
        $this->guzzle = new Client();
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function request()
    {
        try {
            if($this->token) {
                $token = $this->token;
            } else {
                $token = AuthToken::signAuthToken(
                    openssl_pkey_get_private($this->userInfo['private_key']),
                    $this->userInfo['session_id'],
                    $this->userInfo['uid'],
                    $this->method, $this->uri, $this->body);
            }

            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token,
                'Mixin-Device-Id' => Uuid::uuid4()->toString()
            ];

            if($this->headers) {
                $headers = array_merge($headers, $this->headers);
            }

            $requestParams = [
                'headers' => $headers
//                'on_stats' => function (TransferStats $stats) {
//                    echo Psr7\str($stats->getRequest());
//                    echo "---------\r\n";
//                    echo Psr7\str($stats->getResponse());
//                }
            ];
            if($this->body) {
                $requestParams['json'] = $this->body;
            }

            $response = $this->guzzle->request(
                $this->method,
                $this->baseApi.$this->uri,
                $requestParams
            );


            $result = $response->getBody()->getContents();
            return json_decode($result, true);
        } catch (RequestException $e) {
//            echo Psr7\str($e->getRequest());
            echo $e->getMessage();
        }
    }

}