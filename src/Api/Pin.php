<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/24
 * Time: 14:55
 */

namespace Zamseam\Mixin\Api;

use Zamseam\Mixin\Encrypt\Pin as EncryptPin;

class Pin extends ApiBase
{
    private $apiList = [
        'updatePin' => '/pin/update',
        'verifyPin' => '/pin/verify'
    ];

    /**
     * 修改/创建pin
     */
    public function updatePin($newPin, $pinToken, $oldPin = '')
    {
        $request = $this->request->setUri($this->apiList['updatePin']);
        $request = $request->setMethod('POST');

        $iterator = time();

        $request = $request->setBody([
            'old_pin' => $oldPin ? EncryptPin::encryptPin($oldPin, $this->userInfo['private_key'], $pinToken, $this->userInfo['session_id'], $iterator) : '',
            'pin'     => EncryptPin::encryptPin($newPin, $this->userInfo['private_key'], $pinToken, $this->userInfo['session_id'], $iterator+1)
        ]);
        $request = $request->request();
        return $request;
    }

    public function verifyPin($pin, $pinToken)
    {
        $request = $this->request->setUri($this->apiList['verifyPin']);
        $request = $request->setMethod('POST');

        $request = $request->setBody([
            'pin'     => EncryptPin::encryptPin($pin, $this->userInfo['private_key'], $pinToken, $this->userInfo['session_id'], time())
        ]);
        $request = $request->request();
        return $request;
    }
}