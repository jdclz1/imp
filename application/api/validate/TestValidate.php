<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/9
 * Time: 0:38
 */

namespace app\api\validate;


use think\Validate;

class TestValidate extends Validate
{
    protected $rule = [
            'name' => 'require|max:10',
            'email' => 'email'
    ];
}