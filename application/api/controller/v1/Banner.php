<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/8
 * Time: 19:19
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;

class Banner
{
    /**
     * 获取指定的id的banner信息
     * @id banner的id号
     * @url /banner/:id
     * @http GET
     * z.cn/api/v1/banner/1
     */
    public function getBanner($id){
//        AOP 面向切面编程
        (new IDMustBePostiveInt())->goCheck();
//        $daTa=[
//            'name' => 'vendor11111111',
//            'email' => 'vendorqq.com'
//        ];
//        $data = [
//            'id' => $id
//        ];
//        $validate = new Validate([
//            'name' => 'require|max:10',
//            'email' => 'email'
//        ]);
//        $validate = new TestValidate();
//        $validate = new IDMustBePostiveInt();
//
//        $result = $validate->batch()->check($data);
//             var_dump($validate ->getError());
        //        独立验证
//        验证器
        $banner = BannerModel::getBannerById($id);
//        $data = $banner->toArray();  //隐藏列
//        unset($data['delete_time']);
//          $banner->hidden(['update_time','delete_time']);
//            $banner->visible(['id']);
//        $banner = BannerModel::get($id);  //建议用静态的调用方式
//        $banner = BannerModel::with(['items','items.img'])->find($id);  //建议用静态的调用方式
//        8-4 隐藏字段模型
//        find,all,select,get
//        $banner = new BannerModel();  //实例化的方式
//        $banner = $banner->get($id);
        if(!$banner){
            throw new BannerMissException();
//            throw new Exception('内部错误');
        }
//        $c = config('setting.img_prefix');
        return $banner;
//        return $data;
//        return  json($banner);
//        var_dump($banner);
//        echo $banner;
    }
}