<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/10
 * Time: 20:20
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id','delete_time','id'];
}