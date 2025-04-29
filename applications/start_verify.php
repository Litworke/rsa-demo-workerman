<?php
require_once __DIR__ . '/../vendor/autoload.php';

use think\facade\Db;
use Workerman\Timer;
use Workerman\Worker;
use Workerman\Connection\TcpConnection;

$server = new Worker("VerifyProtocol://127.0.0.1:20000");
$server->onWorkerStart = function ($worker) {
    Db::setConfig([
        'default' => 'mysql',
        'connections' => [
            'mysql' => [
                'type' => 'mysql',
                'hostname' => '127.0.0.1',
                'username' => 'root',
                'password' => '',
                'database' => 'network_verify',
                'charset' => 'utf8mb4',
                'prefix' => 'fa_',
                'debug' => true,
            ],
        ],
    ]);

    Timer::add(10, function () use ($worker) {
        $time_now = time();
        foreach ($worker->connections as $connection) {
            if (empty($connection->lastMessageTime)) {
                $connection->lastMessageTime = $time_now;
                continue;
            }
            if ($time_now - $connection->lastMessageTime > 55) {
                $connection->close();
            }
        }
    });

    // 保持数据库连接
    Timer::add(50, function () {
        Db::query('select 1');
    });


};

$server->onMessage = function (TcpConnection $connection, $data) {
    $type = $data['type'] ?? '';
    $reflection = new ReflectionClass("Events");
    if ($reflection->hasMethod($type)) {
        $method = $reflection->getMethod($type);
        if ($method->isStatic()) {
            $method->invokeArgs(null, [$connection, $data['data']]);
        }
    }
};

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}