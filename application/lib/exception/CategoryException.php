<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 11:24
 */

namespace app\api\validate;


class CategoryException extends baseException
{
    public $code = 404;
    public $msg = 'ָ����Ŀ�����ڣ��������';
    public $errorCode = 50000;
}