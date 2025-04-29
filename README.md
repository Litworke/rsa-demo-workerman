
# 协议文档

# 通讯协议字段

### 登录

| 字段       | 说明    |
|----------|-------|
| safecode | 软件安全码 |
| username | 用户名   |
| password | 密码    |
| mcode    | 机器码   |

### 注册

| 字段          | 说明  |
|-------------|-----|
| username    | 用户名 |
| password    | 密码  |
| invite_code | 邀请码 |

### 充值

| 字段          | 说明    |
|-------------|-------|
| username    | 用户名   |
| safecode    | 软件安全码 |
| mcode       | 机器码   |
| invite_code | 邀请码   |
| key         | 卡密    |



#### 传输方式

采用大端模式

### 加密方式

采用RSA加密，需要使用公钥进行加密，使用私钥解密

### 签名方式

对要传输对数据加入一个 t 字段 用于存储秒级别的时间戳

如：实际传输数据

```
{"safecode":"m4p2t8mgxc6qi4gsxzqp63wv5","username":"admin","password":"123456","t":1711632794}
```

对数据进行key排序，如排序之后结果

```
{"password":"123456","safecode":"m4p2t8mgxc6qi4gsxzqp63wv5","t":1711633069,"username":"admin"}
```

然后对数据进行url字符串拼接

```
password=123456&safecode=m4p2t8mgxc6qi4gsxzqp63wv5&t=1711633069&username=admin
```

将得到对url字符串进行md5运算

```
md5('password=123456&safecode=m4p2t8mgxc6qi4gsxzqp63wv5&t=1711633069&username=admin)

结果：a8e19cdbf48427d7ed7cf3caa0330d32
```

### 组织发送数据结构

```json
{"type":"login","data":{"safecode":"m4p2t8mgxc6qi4gsxzqp63wv5","username":"admin","password":"123456","t":1711633069},"sign":"a8e19cdbf48427d7ed7cf3caa0330d32"}
```

### 封包

需要将组织好要发送的数据进行rsa加密，然后进行封包
采用包头+包体的结构，前面四个字节为包体的长度

接收的时候需要读取前面四个字节，获取到足够的包体，然后进行rsa解密，解密之后将数据进行json解析，得到签名去对比签名
签名一致通过说明数据没有问题直接使用json结构体里面的数据就可以了


# 部署文档

| 技术栈 | 版本    |
|-----|-------|
| PHP | 7.4以上 |
|workerman|4.1|
|workerman/mysql|1.0|

#### 数据库配置

在 applications/Database/Db.php 修改

```php
self::$db = new Connection('127.0.0.1', '3306', 'root', 'root', 'network_verify');
```

修改成自己的数据库配置信息

代码放到服务器上

```
composer update 
php start.php start
```

以上命令启动

如果需要守护进程启动则运行

```
php start.php start -d
```
