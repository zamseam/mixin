<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/22
 * Time: 10:22
 */

namespace Zamseam\Mixin\Encrypt;

use phpseclib\Crypt\RSA;

class Pin
{
    /**
     * 加密pin
     * @param $pin
     * @param $iterator
     */
    public static function encryptPin($pin, $privateKey, $pinToken, $sessionId, $iterator = 1)
    {
        // ===========================
        // 第一步， 解析rsa私钥（x509格式）
        // ===========================
        $rsa = new RSA();
        if(!$rsa->loadKey($privateKey)){
            exit("load private key fail");
        }

        // ===============================
        // 第二步，解出用于aes-cbc对称加密的key
        // ===============================
        $token = base64_decode($pinToken);
        $rsa->setHash("sha256");
        $rsa->setMGFHash("sha256");
        $keyBytes = $rsa->_rsaes_oaep_decrypt($token, $sessionId);

        // =================================
        // 第三步，使用aes-cbc模式加密（高级对称加密）
        // =================================
        $pinBytes = $pin . pack("P", time()) . pack("P", $iterator);

        $final = self::encrypt_openssl($pinBytes, $keyBytes);

        return $final;
    }

    public static function encrypt_openssl($msg, $key, $iv = null) {
        if (!$iv) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
        }
        $encryptedMessage = openssl_encrypt($msg, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encryptedMessage);
    }


    public static function decrypt_openssl($payload, $key) {
        $raw = base64_decode($payload);
        $iv = substr($raw, 0, 16);
        $data = substr($raw, 16);
        return openssl_decrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }
}