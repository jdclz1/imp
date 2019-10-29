<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


/*return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];*/

use think\Route;

//    测试用
Route::get('api/:version/test', 'api/:version.Test/test');

//z.cn/api/v1/banner/1
//    Route::get('api/v1/banner/:id','api/v1.Banner/getBanner');
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');
//Route::get('banner/:id','api/v1.Banner/getBanner');
//z.cn/api/v1/theme?ids=1,2,3
Route::get('api/:version/theme','api/:version.Theme/getSimpleList');

// 路由使用完整匹配，以下路由需要完整匹配
//'route_complete_match'   => true,
//z.cn/api/v1/theme/1
Route::get('api/:version/theme/:id','api/:version.Theme/getComplexOne');

//z.cn/api/v1/product/by_category?id=3
//Route::get('api/:version/product/by_category','api/:version.Product/getAllInCategory');
// z.cn/api/v1/product/2
//Route::get('api/:version/product/:id','api/:version.Product/getOne',[],['id'=>'\d+']); //190910,传入的ID必须为正整数
//z.cn/api/v1/product/recent
//Route::get('api/:version/product/recent','api/:version.product/getRecent');

//分组路由
Route::group('api/:version/product',function(){
    Route::get('/by_category','api/:version.Product/getAllInCategory');
    Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']); //190910,传入的ID必须为正整数
    Route::get('/recent','api/:version.product/getRecent');
});

//z.cn/api/v1/category/all
Route::get('api/:version/category/all','api/:version.Category/getAllCategories');


//Token令牌
Route::post('api/:version/token/user','api/:version.Token/getToken');
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');

//z.cn/api/v1/address
Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');
Route::get('api/:version/address','api/:version.Address/getUserAddress');


Route::post('api/:version/order','api/:version.Order/placeOrder');

Route::get('api/:version/project','api/:version.Project/getProjectList');
