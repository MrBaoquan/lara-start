<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mrba\LaraStart\Controllers\AuthController;
use Mrba\LaraStart\Controllers\UserController;
use Mrba\LaraStart\Controllers\WXController;

Route::get('/clearsession', function () {
    session()->forget('wechat.oauth_user.default');
});

// 开启微信oauth授权登录代理
Route::group(['middleware' => ['wechat.mock']], function () {
    Route::any('/auth/wx', [AuthController::class, 'wechat']);
});

// 使用微信授权登录代理 获取网页授权用户信息
Route::any('/proxy/auth/wx', [AuthController::class, 'ProxyAuthWechat'])
    ->middleware('proxy.wechat.oauth');

Route::group(['prefix' => 'api', 'middleware' => ['api', 'auth:sanctum']], function () {
    Route::any('/wx/jssdk', [WXController::class, 'JSSDK']);

    // example: 当前已认证用户信息
    Route::post('/userinfo', [UserController::class, 'userinfo']);
});
