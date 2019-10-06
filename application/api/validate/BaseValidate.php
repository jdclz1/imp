<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/9
 * Time: 8:26
 */

namespace app\api\validate;


use app\lib\exception\BaseException;
use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
//        获取http传入的参数
//        对这些参数做检验
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params); //可以提示多个错误
        if(!$result){
            $e = new ParameterException([
//                以下写法更像面向对象
//                'msg' => '',
//                'code' => 400,
//                'errorCode' => 10002
                'msg' => $this->error,

            ]);


//            如果不加会报：{"msg":"参数错误2","errorCode":10000,"request_usr":"\/banner\/0.1"}
//            如果加会报：{"msg":"id必须是正整数","errorCode":10000,"request_usr":"\/banner\/0.1"}
//            相当于报错，要更详细的自带报错
//            $e->msg = $this->error;
            throw $e;
//            $error = $this->error;
//            throw new Exception($error);
        }else{
            return true;
        }
    }


    protected function isPositiveInteger($value,$rule='',$data='',$field=''){
        if(is_numeric($value) && is_int($value+0) && ($value+0) > 0){
            return true;
        }else{
            return false;
//            return $field.'必须是正整数';
        }
    }

    protected function isMobile($value){
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    protected function isNotEmpty($value,$rule='',$data='',$field=''){
        if(empty($value))
        {
            return false;
        }
        else
        {
            return true;
        }
    }


    public function getDataByRule($arrays){
        if(array_key_exists('user_id',$arrays)|array_key_exists('uid',$arrays)){
            throw new ParameterException([
                'msg' => '参数中包含有非法的参数名user_id 或 uid'
            ]);
        }
        $newArray = [];
        foreach($this->rule as $key=>$value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}