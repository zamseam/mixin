<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/9
 * Time: 09:12
 */
namespace Zamseam\Mixin\Encrypt;

use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;

class AuthToken {

    /**
     * 生成请求的auth token
     * @param $method 接口请求的方法 GET/POST
     * @param $uri 接口请求的路由
     * @param $body 接口请求的内容
     * @return string
     */
    public static function signAuthToken($privateKey, $sessionId, $uid, $method, $uri, $body = '')
    {
        if(is_array($body)) {
            $body = json_encode($body);
        }
        // 过期时间
        $expire = strtotime('+ ' . 30*3 . 'day');

        $sig = hash('sha256', $method.$uri.$body);

        // 生成一个版本4的uuid
        $uuid4 = Uuid::uuid4();

        $data = array(
            "uid" => $uid,
            "sid" => $sessionId,
            "iat" => time(),
            "exp" => $expire,
            "jti" => $uuid4->toString(),
            "sig" => $sig
        );


        $jwt = JWT::encode($data, $privateKey, 'RS512');
        return $jwt;
    }
}