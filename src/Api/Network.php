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
        'snapshots' => '/network/snapshots',
    ];

    public function snapshots($offset, $limit = 500)
    {
        $request = $this->request->setUri($this->apiList['snapshots']. '?offset='. $offset . '&limit=' . $limit. '&asset_id=17909769-5343-38cd-b05a-483cf6eef21f');
        $request = $request->setMethod('GET');
        $request = $request->request();
        return $request;
    }
}