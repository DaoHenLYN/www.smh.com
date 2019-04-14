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

//后台路由 -----------------------------
/*
prefix  路由前缀
namespace 命名空间
middleware  中间件

*/
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
     // 后台登录
     Route::get('login','LoginController@login');

     //后台登录验证码
     Route::get('captcha/{id}','LoginController@captcha');
     // 后台登录处理
     Route::post('dologin','LoginController@dologin');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'islogin'],function(){

    // 加密测试
    // Route::get('jiam','LoginController@jiami');

    // 后台首页
    Route::get('index','IndexController@index');
    // 欢迎页面
    Route::get('welcome','IndexController@welcome');
    // 退出登录
    Route::get('logout','IndexController@logout');
    // 管理员模块
    Route::resource();
});


// 前台路由 ——————————————————————————————————————————————————————————