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

Route::any('/wechat', 'WechatController@serve');
Route::any('/menu', 'MenuController@menu');
Route::any('/menu/all', 'MenuController@all');


Route::middleware(['web', 'wechat.oauth'])->group(function () {
    Route::get('/view', function (\EasyWeChat\Foundation\Application $app) {
        $user = session('wechat.oauth_user');
        $js = $app->js;
        return view('view', compact(['user', 'js']));

//        dd($user);
    });

    Route::get('/view1', function (\EasyWeChat\Foundation\Application $app) {
        $user = session('wechat.oauth_user');
        $js = $app->js;
        return view('view1', compact(['user', 'js']));

//        dd($user);
    });

});
