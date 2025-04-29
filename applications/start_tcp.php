<?php
require_once __DIR__ . '/../vendor/autoload.php';

use think\facade\Db;
use Workerman\Timer;
use Workerman\Worker;
use Workerman\Connection\TcpConnection;

$server = new Worker("tcp://127.0.0.1:8080");
$server->onWorkerStart = function ($worker) {

};

$server->onMessage = function (TcpConnection $connection, $data) {
   print_r(json_decode($data,true));
};

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}