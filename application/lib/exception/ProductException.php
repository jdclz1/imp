<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 10:41
 */

namespace app\api\validate;


use app\lib\exception\BaseException;

class ProductException extends BaseException
{
    public $code = 404;
    public $msg = 'ָ产品不存在，请检查';
    public $errorCode = 20000;
}