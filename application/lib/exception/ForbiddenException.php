<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/13
 * Time: 2:27
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}