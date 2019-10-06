<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/8/25
 * Time: 21:41
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\ThemeException;

class Theme
{
    /**
     * @url /theme?ids=id1,id2,id3,....
     * @return 一组theme模型
     *z.cn/api/v1/theme?ids=1,2,3
     */
    public function getSimpleList($ids=''){
        (new IDCollection())->goCheck();
//        return 'success';
        $ids = explode(',',$ids);
//        写在外面
        $result = ThemeModel::with('topicImg,headImg')
            -> select($ids);
        if($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws ThemeException
     * @throws \app\lib\exception\ParameterException
     */
    public function getComplexOne($id){
//        return 'success';
        (new IDMustBePostiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if(!$theme){
            throw new ThemeException();
        }
        return $theme;
    }
}