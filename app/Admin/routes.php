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

    $router->resource('/wxuser',WeixinController::class);

    $router->resource('/wxmedia',WeimediaController::class);

    $router->get('/wxsendmsg','WeixinController@sendMsgView');      //
    $router->post('/wxsendmsg','WeixinController@sendMsg');


});
