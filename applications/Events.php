<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Support\InviteCode;
use Support\Pack;
use Support\Str;
use think\facade\Db;
use Workerman\Connection\TcpConnection;

class Events
{
    public static function ping(TcpConnection $connection, $data)
    {
        Pack::success($connection, "pong");
    }

    public static function login(TcpConnection $connection, $data)
    {
        $safecode = $data['safecode'] ?? '';
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $mcode = $data['mcode'] ?? '';
        if('yanyu' !=$username){
            Pack::error($connection,'用户名必须为yanyu',0);
        }
        $result = [
            'password' => $password,
            'username' => $username,
            'safecode'  => $safecode,
        ];
        Pack::send($connection, 1, 'success', $result);
    }

    public static function register(TcpConnection $connection, $data)
    {
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $inviteCode = $data['invite_code'] ?? '';
        $user = Db::name('user')->where('username', $username)->find();
        if ($user) {
            Pack::error($connection, "该用户已被注册");
            return;
        }
        $salt = Str::generateRandomString();
        $insert = [
            'username' => $username,
            'password' => Str::getPassword($password, $salt),
            'salt' => $salt,
            'createtime' => time(),
        ];
        $insert_id = Db::name('user')->insert($insert);
        if (!$insert_id) {
            Pack::error($connection, "用户注册失败");
            return;
        }
        Pack::success($connection, "用户注册成功");
    }


    public static function recharge(TcpConnection $connection, $data)
    {
        $username = $data['username'] ?? '';
        $key = $data['key'] ?? '';
        $mcode = $data['mcode'] ?? '';
        $safecode = $data['safecode'] ?? '';
        $inviteCode = $data['invite_code'] ?? '';

        $data['username'] = $username;
        Pack::send($connection, 1, 'success', $data);
    }
}