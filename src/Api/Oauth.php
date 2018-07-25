<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/7/25
 * Time: 15:38
 */

namespace Zamseam\Mixin\Api;


class Oauth extends ApiBase
{
    private $apiList = [
        'token' => '/oauth/token'
    ];

    /**
     * 获取token
     * @param $code
     */
    public function getOauthToken($clientId, $code, $clientSercet)
    {
        $request = $this->request->setUri($this->apiList['token']);
        $request = $request->setMethod('POST');

        $request = $request->setBody([
            'client_id' => $clientId,
            'code'  => $code,
            'client_secret' => $clientSercet
        ]);
        $request = $request->request();
        return $request;
    }
}