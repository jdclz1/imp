<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/9
 * Time: 12:36
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误2';
    public $errorCode = 10000;
}