<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('goods', 'GoodsController');
    $router->resource('langs', 'LangController');
    $router->resource('buttons', 'ButtonController');
    $router->resource('goods-group', 'GoodsGroupController');
    $router->resource('carmis', 'CarmisController');
    $router->resource('coupon', 'CouponController');
    $router->resource('emailtpl', 'EmailtplController');
    $router->resource('pay', 'PayController');
    // 订单补单路由（必须在 resource 之前）
    $router->post('order/complete-order', 'OrderController@completeOrder');
    $router->resource('order', 'OrderController');
    // 用户余额管理路由（必须在 resource 之前）
    $router->post('user/manage-money', 'UserController@manageMoney');
    $router->resource('user', 'UserController');
    $router->resource('invite', 'InviteUserController');
    $router->resource('withdraw', 'WithdrawController');
    $router->get('import-carmis', 'CarmisController@importCarmis');
    $router->get('system-setting', 'SystemSettingController@systemSetting');
    $router->get('email-test', 'EmailTestController@emailTest');
    $router->resource('article', 'ArticleController');
    $router->resource('article-category', 'ArticleCategoryController');
    // Telegram批量群发路由
    $router->get('telegram-broadcast', 'TelegramBroadcastController@index');
    $router->post('telegram-broadcast/send', 'TelegramBroadcastController@send');
});
