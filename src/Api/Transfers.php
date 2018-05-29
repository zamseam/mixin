<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/28
 * Time: 09:38
 */

namespace Zamseam\Mixin\Api;

use Zamseam\Mixin\Encrypt\Pin as EncryptPin;

class Transfers extends ApiBase
{

    private $apiList = [
        'transfers' => '/transfers',
        'verifyPayment' => '/payments',
        'readTransfers' => '/transfers/trace/'
    ];

    public function transfers($assetId, $counterUid, $amount, $pin, $pinToken, $traceId, $memo = '')
    {
        $request = $this->request->setUri($this->apiList['transfers']);
        $request = $request->setMethod('POST');

        $request = $request->setBody([
            'pin'     => EncryptPin::encryptPin($pin, $this->userInfo['private_key'], $pinToken, $this->userInfo['session_id'], time()),
            'asset_id' => $assetId,
            'amount'  => $amount,
            'counter_user_id' => $counterUid,
            'trace_id' => $traceId,
            'memo' => $memo
        ]);
        $request = $request->request();
        return $request;
    }

    // status =>  pending, paid
    public function verifyPayment($assetId, $counterUid, $amount, $traceId)
    {
        $request = $this->request->setUri($this->apiList['verifyPayment']);
        $request = $request->setMethod('POST');

        $request = $request->setBody([
            'asset_id' => $assetId,
            'amount'  => $amount,
            'counter_user_id' => $counterUid,
            'trace_id' => $traceId,
        ]);
        $request = $request->request();
        return $request;
    }

    public function readTransfers($traceId)
    {
        $request = $this->request->setUri($this->apiList['readTransfers'].$traceId);
        $request = $request->setMethod('GET');

        $request = $request->request();
        return $request;
    }
}