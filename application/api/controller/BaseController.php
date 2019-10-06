<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/13
 * Time: 16:38
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token as TokenServices;

class BaseController extends Controller
{
//    以下方法在token中，关于权限的校验统一放在这里，可以减少很多代码
    protected function checkPrimaryScope()
    {
        TokenServices::needPrimaryScope();
    }

    protected function checkExclusiveScope(){
        TokenServices::needExclusiveScope();
    }
}