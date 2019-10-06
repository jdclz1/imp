<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 15:26
 */

namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code=''){
//        return 'aaa';
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token'=>$token
        ];
    }
}