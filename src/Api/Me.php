<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/24
 * Time: 16:24
 */

namespace Zamseam\Mixin\Api;


class Me extends ApiBase
{
    private $apiList = [
        'updateProfile' => '/me'
    ];

    public function updateProfile($fullName, $avatar = '')
    {
        $request = $this->request->setUri($this->apiList['updateProfile']);
        $request = $request->setMethod('POST');
        $request = $request->setBody([
            'full_name' => $fullName,
            'avatar'    => $avatar
        ]);
        $request = $request->request();
        return $request;
    }
}