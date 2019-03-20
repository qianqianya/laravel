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

//支付宝支付 通知回调
Route::post('payNotify','Pay\AlipayController@notify');

//支付展示
Route::any('payList/{o_id}','Pay\AlipayController@payList');

//同步
Route::any('sync','Pay\AlipayController@sync');

//异步
Route::any('async','Pay\AlipayController@async');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//上传
Route::get('/upload','Goods\GoodsController@uploadIndex');

//上传pdf格式
Route::post('/goods/upload/pdf','Goods\GoodsController@uploadPDF');

//电影票购买
Route::any('/movie','Movie\MovieController@movie')->middleware('check.login.token');

//微信
Route::get('/weChat','weChat\weChatController@weChat');

Route::post('/weChat','weChat\weChatController@weChatToken');

Route::post('/weChatToken','weChat\weChatController@validToken');
Route::get('/weChatToken','weChat\weChatController@validToken');

//创建菜单
Route::any('/createMenu','weChat\weChatController@createMenu');

//群发
Route::any('/all','weChat\weChatController@all');

//获取永久素材列表
Route::get('/materialList','weChat\weChatController@materialList');

//上传永久素材
Route::get('/upMaterial','weChat\weChatController@upMaterial');

//创建菜单
Route::post('/material','weChat\weChatController@materialTest');

//素材添加
Route::get('/form/show','weChat\weChatController@formShow');     //表单测试
Route::post('/form/test','weChat\weChatController@formTest');     //表单测试

//微信支付测试
Route::get('/payTest/{o_id}','weChat\PayController@test');
Route::any('/payShow','weChat\PayController@payselect');

//微信支付通知回调
Route::post('/payNotice','weChat\PayController@notice');

//微信登陆
Route::get('wxlogin','weChat\weChatController@wxlogin');

//接收code
Route::get('/wxGetcode','weChat\weChatController@wxGetcode');

//微信 JSSDK
Route::get('/jssdkTest','weChat\weChatController@jssdkTest');       // 测试


Route::get('/weixin','weixin\weixinController@weChat');

Route::post('/weixin','weixin\weixinController@weChatToken');

Route::post('/wxToken','weixin\weixinController@validToken');
Route::get('/wxToken','weixin\weixinController@validToken');

Route::any('/userList','weChat\weChatController@userList');

Route::get('/zhenji','zhenji\ZhenjiController@zhenji');
Route::get('/login','zhenji\ZhenjiController@login');
Route::get('/reg','zhenji\ZhenjiController@reg');



