<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/6/9
 * Time: 9:40
 */

namespace app\lib\exception;

//这里面把think\Exception改为如下就不报错了。
use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(\Exception $e){  //改为基类的exception
//        return json('~~~~~~~~~~~~~');
        if($e instanceof BaseException){
//            如果是自定义的异常,给用户看的异常，一般是用户的操作错误
//            echo '1';
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
//            echo '2';
//            var_dump($e);
//            echo '3';
//            var_dump(new BaseException());
//            echo '4';
//            返回给用户的错误，但是开发阶段需要了解详细报错以便找到原因，所以还是需要TP5自带的详细报错，正好可以用app_debug这个配置项来做
            $switch = true;
//            if($switch){
//            Config::get('app_debug') 另一种写法
            if(config('app_debug')){
//               本来的TP5的方法，给覆写了，只要调用原来的方法即可，实现最详细的报错信息
                return parent::render($e);

            }else{
//                返回给用户的内部错误，不需要用户知道的。
                $this->code = 500;
                $this->msg = '服务器内部错误，不想告诉你';
                $this->errorCode = 999;
//                一般内部的错误是需要写日志的，以便后面去查
                $this->recordErrorLog($e);

            }
        }

        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'request_usr' => $request->url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $e){
//        因为在config里面配置了关闭log日志，所以，需要在这里开启一下
        Log::init([
           'type' => 'File',
           'path' => LOG_PATH,
           'level' => ['error']
        ]);
//        自定义往日志里面写的内容
        Log::record($e->getMessage(),'error');
    }
}