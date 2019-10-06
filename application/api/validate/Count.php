<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 10:14
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' =>'isPositiveInteger|between:1,15'
    ];
}