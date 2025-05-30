<?php

use Support\Rsa;
use Support\Sign;
require_once __DIR__ . '/vendor/autoload.php';

$a = ['safecode' => 'm4p2t8mgxc6qi4gsxzqp63wv5', 'username' => 'admin', 'password' => '123456', 't' => time()];
$sign = Sign::generate($a);
$data = ['type' => 'login', 'data' => $a, 'sign' => $sign];
$body_json_str = Rsa::encrypt(json_encode($data));
$total_length = 4 + strlen($body_json_str);


// 创建一个 TCP/IP socket 资源
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: " . socket_strerror(socket_last_error()) . "\n";
}

// 连接到服务器
$result = socket_connect($socket, '127.0.0.1', 20000);
if ($result === false) {
    echo "socket_connect() failed: " . socket_strerror(socket_last_error($socket)) . "\n";
}

// 发送数据
socket_write($socket, pack('N', $total_length) . $body_json_str, $total_length);

// 从服务器接收数据
$response = socket_read($socket, 2048); // 2048 是接收数据的最大长度
var_dump($response);
$data = \Support\Rsa::decrypt($response);
// 关闭 socket 连接
socket_close($socket);
print_r(json_decode($data, true));

