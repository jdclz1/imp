<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
//    public function getUrlAttr($value,$data){ //读取器
    protected function prefixImgUrl ($value,$data){
//        var_dump($value);   //这个值的数组
//        $c=$value;    //url这一列的值
        $finalUrl = $value;
        if($data['from'] == 1){
            $finalUrl = config('setting.img_prefix').$value;
        }
        return $finalUrl;
//        var_dump($finalUrl);
//        return config('setting.img_prefix').$value;

    }
}
