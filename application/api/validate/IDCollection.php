<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/8/25
 * Time: 22:15
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' =>'require|checkIDs'
    ];

    protected $message =[
//      'ids' => 'ids�����������Զ��ŷָ��Ķ��������'
      'ids' => 'ids params must be int separated by comma ,'
    ];

    protected function checkIDs($value){
        $values = explode(',',$value);
        if(empty($values)){
            return false;
        }
        foreach ($values as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}