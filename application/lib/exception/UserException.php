<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/10
 * Time: 23:17
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}