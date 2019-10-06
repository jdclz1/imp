<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/8/25
 * Time: 21:42
 */

namespace app\api\model;


use think\Model;

class Theme extends BaseModel
{
    protected $hidden = ['delete_time','update_time','topic_img_id','head_img_id'];
//    定义两个关联关系，因为查询的是theme，所以在这里定义，不在image里面定义，不用haseone,两者的区别在于外键放在哪里，放在theme里面用belongsTo
    public function topicImg(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public function headImg(){
        return $this->belongsTo('Image','head_img_id','id');
    }

    public function products(){
        return $this->belongsToMany('Product','theme_product','product_id',
            'theme_id');
    }

    public static function getThemeWithProducts($id){
        $theme = self::with('products,topicImg,headImg')->find($id);
        return $theme;
    }
}