<?php

namespace Support;

use Workerman\Connection\TcpConnection;

class Pack
{
    public static function send(TcpConnection $connection, $code, $type, $data): ?bool
    {
        $data['t'] = time();
        return $connection->send(
            [
                'code' => $code,
                'type' => $type,
                'data' => $data
            ]
        );
    }

    public static function error(TcpConnection $connection, $msg, $code = 0): ?bool
    {
        return self::send($connection, $code, 'error', ['msg' => $msg]);
    }

    public static function success(TcpConnection $connection, $msg, $code = 1): ?bool
    {
        return self::send($connection, $code, 'success', ['msg' => $msg]);
    }

}