<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/30
 * Time: 21:14
 */

namespace app\api\model;


class t100Model extends BaseModel
{
    protected $connection = [
        'type' => '\think\db\connector\Oracle',
        'hostname' => '172.16.100.187',
//        'database' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.100.187)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = topprd))) ',
        'database'        => 'topprd',
        'username' => 'dsdemo',
        'password' => 'dsdemo',
        'hostport' => '1521',
        'prefix'          => '',
    ];
}