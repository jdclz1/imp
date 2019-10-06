<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 22:13
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
//    public $msg = 'Token is already expire';
    public $errorCode = 10001;
}