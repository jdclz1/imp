<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 16:33
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 404;
//    public $msg = '微信服务器接口调用失败';
    public $msg = 'English:Using WeChat service is fail';
    public $errorCode = 999;
}