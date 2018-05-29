<?php
/**
 * Created by PhpStorm.
 * User: zhangyuanhao
 * Date: 2018/5/29
 * Time: 14:29
 */

use PHPUnit\Framework\TestCase;

use Zamseam\Mixin\MixinClient;

class NetworkTest extends TestCase
{
    public function provider()
    {
        $config = require_once __DIR__ . DIRECTORY_SEPARATOR . '../config/owner.php';
        return $config;
    }

    /**
     * @dataProvider provider
     */
    public function testReadNetwork($userInfo, $pinToken)
    {
        $mixin = new MixinClient($userInfo);

        $mixin->setModel('network');
        $result = $mixin->readNetwork();
        var_export($result);
    }

    /**
     * @dataProvider provider
     */
    public function testReadNetworkAsset($userInfo, $pinToken)
    {
        $mixin = new MixinClient($userInfo);

        $mixin->setModel('network');
        $result = $mixin->readNetworkAsset('17909769-5343-38cd-b05a-483cf6eef21f');
        var_export($result);
    }

    /**
     * @dataProvider provider
     */
    public function testSnapshots($userInfo, $pinToken)
    {
        $mixin = new MixinClient($userInfo);

        $mixin->setModel('network');
        $result = $mixin->snapshots('17909769-5343-38cd-b05a-483cf6eef21f', 9, 2);
        var_export($result);
    }

    /**
     * @dataProvider provider
     */
    public function testReadSnapshots($userInfo, $pinToken)
    {
        $mixin = new MixinClient($userInfo);

        $mixin->setModel('network');
        $result = $mixin->readSnapshots('89d96805-c1d5-478d-963d-2fdece16e150');
        var_export($result);
    }

}