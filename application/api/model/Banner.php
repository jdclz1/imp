<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/9
 * Time: 8:43
 */

namespace app\api\model;


use think\Db;
use think\Exception;
use think\Model;

//class Banner
class Banner extends BaseModel  #变为模型
{
    protected $hidden = ['delete_time','update_time']; //隐藏列

    public function items(){
        return $this->hasMany('BannerItem','banner_id','id'); //要关联的模型，外键，主键
    }
//    protected $table = 'category';
    public static function getBannerById($id){

//        try{
//            1/0;
//        }catch(Exception $ex){
//            throw $ex;
//        }
//        return 'this is banner info';
//        return null;
//        7-1 数据库操作
//        return 'aaaaaaaaaaaaaaa';
//        $result = Db::query(
//            'select * from banner_item where banner_id=?',[$id]);
//        return $result;
//        var_dump($result);
//        $result = Db::table('banner_item')->where('banner_id','=',$id)->find();
//        $result = Db::table('banner_item')
////            ->fetchSql()
//            ->where('banner_id','=',$id)->find();
//        return $result;

        $banner = self::with(['items','items.img'])->find($id);  //建议用静态的调用方式
        return $banner;
    }
}