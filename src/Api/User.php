<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/23
 * Time: 14:15
 */
namespace Zamseam\Mixin\Api;

use Zamseam\Mixin\Encrypt\SessionSecret;

class User extends ApiBase
{

    private $apiList = [
        'createUser' => '/users',
        'readUsers'  => '/users/fetch'
    ];

    /**
     * 创建用户
     */
    public function createUser($fullName)
    {
        $request = $this->request->setUri($this->apiList['createUser']);
        $request = $request->setMethod('POST');
        $key = SessionSecret::createKey();
        $body = [
            'session_secret' => SessionSecret::formatPublicKey($key['publickey']),
            'full_name'      => $fullName
        ];
        $request = $request->setBody($body);
        $request = $request->request();
        return [
            'mixinReturn' => $request,
            'privateKey'  => $key['privatekey']
        ];
    }

    /**
     * 读取用户
     * @param $userIds
     * @return $this
     */
    public function readUsers($userIds)
    {
        $request = $this->request->setUri($this->apiList['readUsers']);
        $request = $request->setMethod('POST');
        $request = $request->setBody($userIds);
        $request = $request->request();
        return $request;
    }
}