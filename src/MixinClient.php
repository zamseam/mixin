<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/23
 * Time: 14:55
 */
namespace Zamseam\Mixin;

class MixinClient
{

    private $m;

    private $mList = [
        'user'  => 'User',
        'asset' => 'Asset',
        'me'    => 'Me',
        'pin'   => 'Pin',
        'transfers' => 'Transfers',
        'address' => 'Address',
        'withdraw' => 'Withdraw',
        'network'  => 'Network',
        'oauth'    => 'Oauth'
    ];

    private $userInfo;

    public function __construct($userInfo = [])
    {
        $this->userInfo = $userInfo;
    }

    public function setModel($m)
    {
        $this->m = $m;
    }

    public function __call($name, $arguments)
    {
        if(!$this->m || !isset($this->mList[$this->m]))
            return false;

        $class = 'Zamseam\\Mixin\\Api\\' . $this->mList[$this->m];
        $foo = new $class($this->userInfo);

        return call_user_func_array(array($foo, $name), $arguments);
    }
}