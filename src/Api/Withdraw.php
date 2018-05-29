<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/28
 * Time: 10:48
 */

namespace Zamseam\Mixin\Api;

use Zamseam\Mixin\Encrypt\Pin as EncryptPin;

class Withdraw extends ApiBase
{
    private $apiList = [
        'withdrawal' => '/withdrawals'
    ];

    public function withdraw($addressId, $amount, $pin, $pinToken, $traceId, $memo = '')
    {
        $request = $this->request->setUri($this->apiList['withdrawal']);
        $request = $request->setMethod('POST');

        $request = $request->setBody([
            'address_id' => $addressId,
            'pin'     => EncryptPin::encryptPin($pin, $this->userInfo['private_key'], $pinToken, $this->userInfo['session_id'], time()),
            'amount'  => $amount,
            'trace_id' => $traceId,
            'memo' => $memo
        ]);
        $request = $request->request();
        return $request;
    }
}