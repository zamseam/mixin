<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/28
 * Time: 11:47
 */

namespace Zamseam\Mixin\Api;


class Network extends ApiBase
{
    private $apiList = [
        'readNetwork' => '/network',
        'snapshots' => '/network/snapshots',
        'readNetworkAsset' => '/network/assets/',
        'readSnapshots' => '/network/snapshots/'
    ];

    public function snapshots($assetId = '', $offset = 0, $limit = 500)
    {
        $request = $this->request->setUri($this->apiList['snapshots']. '?offset='. $offset . '&limit=' . $limit.'&asset='.$assetId);
        $request = $request->setMethod('GET');
        $request = $request->request();
        return $request;
    }

    public function readNetwork()
    {
        $request = $this->request->setUri($this->apiList['readNetwork']);
        $request = $request->setMethod('GET');
        $request = $request->request();
        return $request;
    }

    public function readNetworkAsset($assetId)
    {
        $request = $this->request->setUri($this->apiList['readNetworkAsset'].$assetId);
        $request = $request->setMethod('GET');
        $request = $request->request();
        return $request;
    }

    public function readSnapshots($snapshotId)
    {
        $request = $this->request->setUri($this->apiList['readSnapshots'].$snapshotId);
        $request = $request->setMethod('GET');
        $request = $request->request();
        return $request;
    }
}