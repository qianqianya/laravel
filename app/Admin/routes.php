<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('/goods',GoodsController::class);
    $router->resource('/users',UsersController::class);
    //微信用户
    $router->resource('/wxuser',WeixinController::class);

    //素材
    $router->resource('/wxmedia',WeimediaController::class);
    //永久素材
    $router->resource('/material',MaterialController::class);

    $router->get('/wxsendmsg','WeixinController@sendMsgView');      //
    $router->post('/wxsendmsg','WeixinController@sendMsg');

    $router->get('/oneShot/{id}','WeixinController@oneShot');


});
