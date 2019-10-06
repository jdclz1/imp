<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 11:15
 */

namespace app\api\model;


class Category extends BaseModel
{
    public $hidden = ['delete_time','update_time','create_time'];

    public function img(){
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}