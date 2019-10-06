<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 15:39
 */


namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

//    通过构造函数，得到微信url
    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),
            $this->wxAppID,$this->wxAppSecret,$this->code);
    }


    public function get(){
        $result = curl_get($this->wxLoginUrl);
//        wx返回值
//        openid: "oEee94hiQuD8TUP7SWE9mhdrVdXg"    用户唯一标识
//        session_key: "6T3o9QxaxZnEbn0WR8TUZg=="   会话密钥
        $wxResult = json_decode($result, true);
        if(empty($wxResult)){
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errcode',$wxResult);
//            如果有返回值，但值里面有空值，则报错处理
            if($loginFail){
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }
    }

//    主处理函数
    private function grantToken($wxResult){
//        拿到openid 用户唯一标识
//        数量库里看一下，这个openid是不是已存在
//        如果存在，则不处理，如果不存在那么新增一条user记录
//        生成令牌，准备缓存数据，写入缓存
//        把令牌返回到客户端去
//        key :令牌
//        value:$wxResult,$uid,scope
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenId($openid);
        if($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
//        调用结果
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
//        token: {session_key: "Hft8Eltzo97uyyUNns5NJA==",
//        openid: "oEee94hiQuD8TUP7SWE9mhdrVdXg",
//        uid: 58,
//        scope: 16}
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

//    写入缓存
    private function saveToCache($cachedValue){
//        这个方法该写在哪里好的，一个是common里，一个是基类里，我们定义一个基类处理这个逻辑
        $key = self::generateToken();
//        这个key 由32位数字字母组合 + 时间戳 + 随意定义的盐 组成
//        token: "l2itPpTotAxFbFAjJAngtaRriqeWM8lz1567956654.001HHsTieBU377mJtKr" 上面函数的返回值
//        token: "959285d2e10db53d252f7aaca22c1886" 经过MD5加密后的结果
        $value = json_encode($cachedValue);
//        超时设置 7200秒
        $expire_in = config('setting.token_expire_in');
//      tp5的默认缓存方法，这里其实是建立一个对应关系，将从微信查出来的openid与用户表 及随机生成的key对应
        $request = cache($key, $value, $expire_in);
        if(!$request){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' =>10005
            ]);
        }
//        将令牌返回出去
        return $key;
    }
//    缓存处理
    private function prepareCachedValue($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
//        scope = 16 代表app用户的权限数值
//        $cachedValue['scope'] = 16;
        $cachedValue['scope'] = ScopeEnum::User;

//        scope = 32 代表CMS（管理员）用户的权限数值
//        $cachedValue['scope'] = 32;
        return $cachedValue;
    }
//    如果不存在openid，则在数据库创建一条
    private function newUser($openid){
        $user = UserModel::create([
            'openid' => $openid
        ]);
        return $user->id;
    }

//    如果微信有返回错误码，则将错误信息返回客户端
    private function processLoginError($wxResult){
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errorcode']
        ]);
    }
}
