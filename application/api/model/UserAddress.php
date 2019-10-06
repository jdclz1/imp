<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/10
 * Time: 23:51
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id','delete_time','user_id'];
}