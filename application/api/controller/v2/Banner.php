<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/8
 * Time: 19:19
 */

namespace app\api\controller\v2;

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
     */
    public function getBanner($id){
        return 'This is V2 Version';
    }
}