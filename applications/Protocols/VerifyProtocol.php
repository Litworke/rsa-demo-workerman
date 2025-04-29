<?php

namespace Protocols;

use Support\Rsa;
use Support\Sign;
use Workerman\Connection\ConnectionInterface;

class VerifyProtocol
{
    public static function input($recv_buffer)
    {
        if (strlen($recv_buffer) < 4) {
            return 0;
        }
        $unpack_data = unpack('Ntotal_length', $recv_buffer);
        return $unpack_data['total_length'];
    }

    public static function decode($recv_buffer, $connection)
    {
        $body = substr($recv_buffer, 4);
        $body = Rsa::decrypt($body);
        $data = json_decode($body, true);
        print_r($data);
        if (!Sign::verify($data['data'], $data['sign'])) {
            $connection->send(['type' => 'error', 'data' => ['msg' => '签名错误']]);
            return "";
        }
        return $data;
    }

    public static function encode($data)
    {
        $data['sign'] = Sign::generate($data['data']);
        $body = Rsa::encrypt(json_encode($data));
        $total_length = 4 + strlen($body);
        print_r($body);
        return pack('N', $total_length) . $body;
    }
}