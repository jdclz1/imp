<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 15:38
 */

namespace app\api\model;


class User extends BaseModel
{

    public function address(){
        return $this->hasOne('UserAddress','user_id','id');
    }

    public static function getByOpenId($openid){
        $user = self::where('openid','=',$openid)
            ->find();
        return $user;
    }
}