<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//用户注册
Route::any('userAdd', 'User\UserController@userAdd');

//用户登录
Route::any('loginAdd', 'User\UserController@loginAdd');

//个人中心
Route::any('center','User\UserController@center');

//退出
Route::any('loginQuit','User\UserController@loginQuit');



//商品主页
Route::any('goodsList','Goods\GoodsController@goodsList');

//商品主页删除
Route::any('goodsDel/{goods_id}','Goods\GoodsController@goodsDel')->middleware('check.login.token');

//商品详情
Route::any('goodsDetails/{goods_id}','Goods\GoodsController@goodsDetails')->middleware('check.login.token');
Route::any('/keyword','Goods\GoodsController@keyword')->middleware('check.login.token');




//购物车展示
Route::any('cartList','Cart\CartController@cartList')->middleware('check.login.token');

//购物车添加1
Route::any('cartAdd/{goods_id}','Cart\CartController@cartAdd')->middleware('check.login.token');

//购物车添加2
Route::any('cartAdd2','Cart\CartController@cartAdd2')->middleware('check.login.token');

//购物车删除1
Route::any('cartDel/{goods_id}','Cart\CartController@cartDel')->middleware('check.login.token');

//购物车删除2
Route::any('cartDel2/{c_id}','Cart\CartController@cartDel2')->middleware('check.login.token');




//提交订单
Route::any('orderAdd','Order\OrderController@orderAdd')->middleware('check.login.token');

//订单展示
Route::any('orderList','Order\OrderController@orderList')->middleware('check.login.token');

//删除订单
Route::any('orderDel/{o_id}','Order\OrderController@orderDel')->middleware('check.login.token');

//支付订单
Route::any('orderPay/{o_id}','Order\OrderController@orderPay')->middleware('check.login.token');

//跳转网址
Route::any('Pay','Order\OrderController@pay');

Route::post('payNotify','Pay\AlipayController@notify');//支付宝支付 通知回调

Route::any('payList/{o_id}','Pay\AlipayController@payList');
Route::any('sync','Pay\AlipayController@sync');
Route::any('async','Pay\AlipayController@async');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/upload','Goods\GoodsController@uploadIndex');
Route::post('/goods/upload/pdf','Goods\GoodsController@uploadPDF');

Route::any('/movie','Movie\MovieController@movie')->middleware('check.login.token');

Route::get('/weChat','weChat\weChatController@weChat');

Route::post('/weChat','weChat\weChatController@weChatToken');

Route::post('/weChatToken','weChat\weChatController@validToken');
Route::get('/weChatToken','weChat\weChatController@validToken');







