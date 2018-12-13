<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];
use think\Route;

Route::get('api/v1/banner/:id','api/v1.Banner/getBanner');

Route::get('api/v1/theme','api/v1.Theme/getSimpleList');

Route::get('api/v1/theme/:id','api/v1.Theme/getComplexOne');


Route::group('api/v1/product',function(){
    Route::get('/recent','api/v1.Product/getRecent');
    Route::get('/by_category','api/v1.Product/getAllInCategory');
    Route::get('/:id','api/v1.Product/getOne',[],['id'=>'\d+']);
});

Route::get('api/v1/category/all','api/v1.Category/getAllCategories');

Route::post('api/v1/token/user','api/v1.Token/getToken');
Route::post('api/v1/token/app', 'api/v1.Token/getAppToken');
Route::post('api/v1/token/verify', 'api/v1.Token/verifyToken');

Route::post('api/v1/address', 'api/v1.Address/createOrUpdateAddress');
Route::get('api/v1/address', 'api/v1.Address/getUserAddress');

Route::post('api/v1/order','api/v1.Order/placeOrder');
Route::get('api/v1/order/:id','api/v1.Order/getDetail',[],['id'=>'\d+']);
Route::put('api/v1/order/delivery', 'api/v1.Order/delivery');

Route::get('api/v1/order/by_user','api/v1.Order/getSummaryByUser');
Route::get('api/v1/order/paginate', 'api/v1.Order/getSummary');

Route::post('api/v1/pay/pre_order','api/v1.Pay/getPreOrder');
Route::post('api/v1/pay/notify','api/v1.Pay/receiveNotify');
Route::post('api/v1/pay/re_notify','api/v1.Pay/redirectNotify');

Route::post('api/v1/message/delivery', 'api/v1.Message/sendDeliveryMsg');


