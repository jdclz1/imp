<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/10
 * Time: 20:15
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id','delete_time','product_id'];

//    一对一关系
    public function imgUrl(){
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}