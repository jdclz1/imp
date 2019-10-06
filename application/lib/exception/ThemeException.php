<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 7:22
 */

namespace app\api\validate;


use app\lib\exception\BaseException;

class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '主题不存在，请检查ID';
//    public $msg = 'the theme is not exists,please check the theme ID';
    public $errorCode = 30000;
}