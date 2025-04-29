<?php

namespace Support;

class Sign
{
    public static function verify($data, $sign): bool
    {
        ksort($data);
        return self::generate($data) === $sign;
    }

    public static function generate($data): string
    {
        ksort($data);
        return md5(http_build_query($data));
    }
}