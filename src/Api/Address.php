<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/28
 * Time: 10:30
 */

namespace Zamseam\Mixin\Api;

use Zamseam\Mixin\Encrypt\Pin as EncryptPin;

class Address extends ApiBase
{
    private $apiList = [
        'createAddress' => '/addresses',
        'readAddress'   => '/assets/:id/addresses',
        'deleteAddress' => '/addresses/:id/delete'
    ];

    public function createAddress($assetId, $publicKey, $pin, $pinToken, $lable = '')
    {
        $request = $this->request->setUri($this->apiList['createAddress']);
        $request = $request->setMethod('POST');

        $body = [
            'asset_id' => $assetId,
            'public_key' => $publicKey,
            'label'    => $lable,
            'pin'      => EncryptPin::encryptPin($pin, $this->userInfo['private_key'], $pinToken, $this->userInfo['session_id'], time())
        ];
        $request = $request->setBody($body);
        $request = $request->request();
        return $request;
    }

    public function readAddresses($assetId)
    {
        $request = $this->request->setUri(str_replace(':id', $assetId, $this->apiList['readAddress']));
        $request = $request->setMethod('GET');

        $request = $request->request();
        return $request;
    }

    public function deteleAddress($addressId, $pin, $pinToken)
    {
        $request = $this->request->setUri(str_replace(':id', $addressId, $this->apiList['deleteAddress']));
        $request = $request->setMethod('POST');
        $body = [
            'pin'      => EncryptPin::encryptPin($pin, $this->userInfo['private_key'], $pinToken, $this->userInfo['session_id'], time())
        ];
        $request = $request->setBody($body);
        $request = $request->request();
        return $request;
    }
}