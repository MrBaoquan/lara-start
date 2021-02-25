<?php

use Illuminate\Support\Facades\Route;
use Mrba\LaraStart\Controllers\AuthController;

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

Route::get('/test', function () {
    return 'test mrba start';
});

Route::get('/clearsession', function () {
    session()->forget('wechat.oauth_user.default');
});

// 开启微信oauth授权登录代理
Route::group(['middleware' => ['wechat.mock']], function () {
    Route::any('/auth/wechat', [AuthController::class, 'wechat']);
});

// 使用微信授权登录代理 获取网页授权用户信息
Route::any('/proxy/auth/wechat', [AuthController::class, 'ProxyAuthWechat'])->middleware('proxy.wechat.oauth');
