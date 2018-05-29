<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/23
 * Time: 11:23
 */

namespace Zamseam\Mixin\Encrypt;

use phpseclib\Crypt\RSA;

class SessionSecret
{
    public static function createKey()
    {
        $rsa = new RSA();
        // 获取publickey
        $key = $rsa->createKey();

        return $key;
    }

    /**
     * 根据用户的私钥获取用户的公钥
     * @return string
     */
    public static function buildSessionSecret($privateKey)
    {
        // 解析rsa私钥（x509格式）
        $rsa = new RSA();
        if(!$rsa->loadKey($privateKey)){
            exit("load private key fail");
        }
        // 获取publickey
        $publicKey = $rsa->getPublicKey(0);

        $publicKey = str_replace(array("-----BEGIN PUBLIC KEY-----\r\n", "-----END PUBLIC KEY-----", "\r\n"), '', $publicKey);

        return $publicKey;
    }

    /**
     * 格式化公钥
     * @param $publicKey
     * @return mixed
     */
    public static function formatPublicKey($publicKey)
    {
        $newKey = str_replace(array("-----BEGIN PUBLIC KEY-----\r\n", "-----END PUBLIC KEY-----", "\r\n"), '', $publicKey);

        return $newKey;
    }

    /**
     * 格式化私钥
     * @param $publicKey
     * @return mixed
     */
    public static function formatPrivateKey($privateKey)
    {
        $newKey = str_replace(array("-----BEGIN RSA PRIVATE KEY-----\r\n", "-----END RSA PRIVATE KEY-----", "\r\n"), '', $privateKey);

        return $newKey;
    }
}