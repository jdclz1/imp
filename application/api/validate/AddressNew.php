<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/10
 * Time: 22:26
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $rule = [
      'name' => 'require|isNotEmpty',
      'mobile' => 'require|isMobile',
      'province' => 'require|isNotEmpty',
      'city' => 'require|isNotEmpty',
      'country' => 'require|isNotEmpty',
      'detail' => 'require|isNotEmpty'
    ];
}