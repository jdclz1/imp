<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/14
 * Time: 10:14
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id','delete_time','update_time'];
    protected $autoWriteTimestamp = true;
//    protected $createTime = 'create_timestamp';
}