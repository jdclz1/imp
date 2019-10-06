<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/9
 * Time: 9:40
 */

namespace app\lib\exception;


use think\Exception;
//如果下面这个不加，一直报参数错误：exception Use of undefined constant
error_reporting(0);
class BaseException extends Exception
{
//    HTTP状态码 404，200
    public $code = 400;

//    错误具体信息
    public $msg = ‘参数错误111’;

//    自定义错误码
    public $errorCode = 10000;

    public function __construct($params = []){
        if(!is_array($params)){
//            认识不是个错误  6-9 中
            return;
//            throw new Exception('参数必需是数组');
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];

        }

        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }

        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }

}