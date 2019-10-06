<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/8/25
 * Time: 21:41
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = [
        'delete_time','main_img_id','pivot','from','category_id',
        'create_time','update_time'];

    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    public static function getMostRecent($count){
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

    public static function getProductsByCategoryID($categoryID){
        $products = self::where('category_id','=',$categoryID)
            ->select();
        return $products;
    }

//    获取产品详情,先用产品表关联productimage表，然后再到productimage模型里面，去关联img表，分两步处理，相当于两个left join
//致命错误: Call to a member function eagerlyResult() on null  →解决办法 要加return
    public function imgs(){
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function properties(){
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

//    然后组合一下
    public static function getProductDetail($id){
//        $product = self::with('imgs.imgUrl,properties')->find($id);
//        $product = self::with(['imgs.imgUrl','properties'])->find($id);
//        $product = self::with(['imgs.imgUrl'])->with(['properties'])->find($id);
        $product = self::with([
            'imgs' => function($query){
                $query->with(['imgUrl'])
                    ->order('order','asc');
            }
        ])
            ->with(['properties'])->find($id);
        return $product;
    }

}
