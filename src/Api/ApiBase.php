<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/24
 * Time: 10:56
 */

namespace Zamseam\Mixin\Api;

use Zamseam\Mixin\Http\Request;

class ApiBase
{
    protected $userInfo;

    protected $request;

    private $mixinBaseApi = 'https://api.mixin.one';

    public function __construct($userInfo)
    {
        $this->userInfo = $userInfo;
        $this->request = new Request($userInfo, $this->mixinBaseApi);
    }

    public function __call($name, $arguments)
    {
        $this->request = call_user_func_array(array($this->request, $name), $arguments);
        return $this;
    }
}