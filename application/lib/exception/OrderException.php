<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/13
 * Time: 22:57
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errorCode = 80000;
}