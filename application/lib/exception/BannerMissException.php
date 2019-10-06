<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/9
 * Time: 9:43
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的Banner不存在';
    public $errorCode = 40000;
}