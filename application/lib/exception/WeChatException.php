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
//    public $msg = '΢�ŷ������ӿڵ���ʧ��';
    public $msg = 'English:Using WeChat service is fail';
    public $errorCode = 999;
}