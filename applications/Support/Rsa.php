<?php

namespace Support;

class Rsa
{
    private static $privateKey = "-----BEGIN PRIVATE KEY-----
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
craWuzU9bOEb0jD63+PZrWwTJLStkLs=
-----END PRIVATE KEY-----";

    private static $publicKey = "-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAsVt0HClSaWejWSCkTK0l
cCNAJNMdpScwnKO5OkDWkRXqkGDjJTLL+6ba+/r1i+fQgkaGGXzhE0/Nr7bNp/1o
+LNYELZP6NHGIw8P5zNTc6Rhc8tZRgT1Urb3XU2ywBhQyH6+MsI7ZaBDir7Nnqsi
E9J2DrlKWiP5BTxfD0bSEVTYp/qxBPydFXHNNJwdWNc4V0EsRWTtp40msO+tuYA4
boRQLE0io/8YQDpNNPiMHY5Pmt/uF0l5k16D2Z8pXoSF3PslPpX4NUMDXXjB+Ef7
1+aWwN0KXJro/rBNGZOHGNNggSFrC30kWjJoXaPzBQoogDXF5Dpu1jSx8sDgKJf7
so1Sq082O2CW+JvB3+yLHO56gAltXSjaeyO/xgSC4QuGk/80hHHkp9wJTXo7Lh9+
xyfGKdn8LwXX7gf4o0JHLoeKWlJ7Wef53+f1T6IwbgHWFXv69u8P3x5GO/UtygBZ
aeebCW+2xGd/C2aIVTTYZT7cJchSyvAn3ym/tF9lenqa8dRyHButRgP9xZRoS9aA
xxbhLhl/agn+WJDhCi0vCAWjhf5YDOcPdUi1ZdgCrqiBK+u3WN6pH+MskSu2YFf7
KD4OnNnV2Tdv0g7rWOeffRhyUziu287u7hIzszQU2Cm4NwIefWJFZaE86DcVhJWj
72EDTcOtnlGgA51J1KWPK30CAwEAAQ==
-----END PUBLIC KEY-----";

    public static function encrypt($data): string
    {
        // 用公钥加密,base64编码
        openssl_public_encrypt($data, $encryptedData, self::$publicKey);
        return base64_encode($encryptedData);
    }
    
    public static function decrypt($data): string
    {
        // 1.0 先base64解密
        $data = base64_decode($data);
        // 2.0 根据私钥解密
        openssl_private_decrypt($data, $decryptedData, self::$privateKey);
        return $decryptedData;
    }
}