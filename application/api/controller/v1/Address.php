<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/10
 * Time: 21:21
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\UserAddress;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenServices;
use app\api\model\User as UserModel;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use think\Controller;


class Address extends BaseController
{
//
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' =>'createOrUpdateAddress']
    ];

//    protected function checkPrimaryScope(){
//        TokenServices::needPrimaryScope();
//        以下被抽象到Token中
//        $scope = TokenServices::getCurrentTokenVar('scope');
//        if($scope){
//            if ($scope >= ScopeEnum::User) {
//                return true;
//            }else{
//                throw new ForbiddenException();
//            }
//        } else {
//            throw new TokenException();
//        }
//    }

//add 20191028 新增获取地址接口
public function getUserAddress(){
    $uid = TokenServices::getCurrentUid();
    $userAddress = UserAddress::where('user_id', $uid)->find();
    if(!$userAddress){
        throw new UserException([
            'msg' => '用户地址不存在',
            'errorCode' => 6001
        ]);
    }
    return $userAddress;
}

//    POSTMAN ?????????
// ??????z.cn/api/v1/address    ?????post;
// header ??key ? token ;    value???72fa77ab4a737c00579f2a7a2ecf22c1
//{"name":"qiyue","mobile":"18888888888","province":"艾泽拉斯","city":"暴风城","country":"闪金镇","detail":"狮王之傲旅店"}
    public function createOrUpdateAddress(){
//        (new AddressNew())->goCheck();
        $validate = new AddressNew();
        $validate -> goCheck();
//     //000000007200s:102:"{"session_key":"KnA01SiFZxLgC5xTCYiLeQ==","openid":"oEee94hiQuD8TUP7SWE9mhdrVdXg","uid":58,"scope":16}";
        $uid = TokenServices::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }

        $dataArray = $validate->getDataByRule(input('post.'));


        $userAddress = $user->address;  //?????????????????
//      $userAddress ??  {"name":"qiyue","mobile":"18888888888","province":"???????","city":"?????"
//,"country":"??????","detail":"?????????","update_time":"1970-01-01 08:00:00"}

        if(!$userAddress){
            $user->address()->save($dataArray);

        }else{
            $user->address->save($dataArray);
        }
//        return $user;
//        return new SuccessMessage();
        return json(new SuccessMessage(), 201); //???????????
    }

}