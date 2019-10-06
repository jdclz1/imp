<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/9
 * Time: 7:45
 */

namespace app\api\validate;


use think\Validate;

class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
//        'num' =>'in:1,2,3'  //http://z.cn/Banner/0.1?num=4
    ];

    protected $message =[
        'id' => 'ids params must be int在'
    ];
}