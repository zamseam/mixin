<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/29
 * Time: 11:03
 */

use PHPUnit\Framework\TestCase;

use Zamseam\Mixin\MixinClient;

class AssetsTest extends TestCase
{

    public function provider()
    {
        $config = require_once __DIR__ . DIRECTORY_SEPARATOR . '../config/userinfo1.php';
        return $config;
    }

    /**
     * @dataProvider provider
     */
    public function testReadAssets($userInfo, $pinToken)
    {
        $mixin = new MixinClient($userInfo);

        $mixin->setModel('asset');
        $result = $mixin->readAssets();
        var_export($result);
    }

}