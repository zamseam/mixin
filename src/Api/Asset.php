<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/24
 * Time: 10:16
 */

namespace Zamseam\Mixin\Api;

class Asset extends ApiBase
{
    private $apiList = [
        'readAssets' => '/assets',
        'readAsset'  => '/assets/'
    ];

    public function readAssets()
    {
        $request = $this->request->setUri($this->apiList['readAssets']);
        $request = $request->setMethod('GET');
        $request = $request->request();
        return $request;
    }

    public function readAsset($assetId)
    {
        $request = $this->request->setUri($this->apiList['readAsset'].$assetId);
        $request = $request->setMethod('GET');
        $request = $request->request();
        return $request;
    }
}