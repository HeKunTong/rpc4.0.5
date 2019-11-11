<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19-10-14
 * Time: 上午10:34
 */

require_once 'vendor/autoload.php';

use EasySwoole\Rpc\Config;
use EasySwoole\Rpc\Rpc;
use EasySwoole\Rpc\NodeManager\RedisManager;
use EasySwoole\Rpc\Response;

//cli模拟，跨进程，重新new rpc对象
$manager = new RedisManager('127.0.0.1');

$config = new Config();
$config->setNodeManager($manager);
$rpc = new Rpc($config);

go(function () use ($rpc) {
    $client = $rpc->client();
    $client->addCall('user', 'register', ['arg1', 'arg2'])
        ->setOnFail(function (Response $response) {
            print_r($response->toArray());
        })
        ->setOnSuccess(function (Response $response) {
            print_r($response->toArray());
        });

    $client->exec();
});