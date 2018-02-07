<?php

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', 'UserController@getUserInfo');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/token/refresh', 'Auth\LoginController@refresh');
Route::post('/logout', 'Auth\LoginController@logout');
Route::post('/test', 'ClassTeacherController@export');
Route::middleware('auth:api')->group(function() {
    // 用户管理
    Route::Resource('admin', 'UserController');
    Route::post('/admin/modify', 'UserController@modify' );
    Route::post('/admin/{id}/reset', 'UserController@reset');
    Route::post('/admin/uploadAvatar', 'UserController@uploadAvatar');
    Route::post('/admin/upload', 'UserController@upload');
    Route::post('/admin/export', 'UserController@export');
    Route::post('/admin/exportAll', 'UserController@exportAll');
    Route::post('/admin/deleteAll', 'UserController@deleteAll');

    // 角色管理
    Route::Resource('role', 'RoleController');
    Route::get('getRoles', 'RoleController@getRoles');

    // 其他支持API
    Route::get('/getSession', 'SessionController@getSession');
    Route::get('/getDefaultSession', 'SessionController@getDefaultSession');
    Route::get('/getTeacher', 'TeacherController@getTeacher');
    Route::get('/getTeach', 'TeachController@getTeach');

    // 学期管理
    Route::Resource('session', 'SessionController');
    Route::post('/session/upload', 'SessionController@upload');

    // 行政领导管理
    Route::Resource('leader', 'LeaderController');
    Route::post('/leader/upload', 'LeaderController@upload');
    Route::post('/leader/export', 'LeaderController@export');
    Route::post('/leader/exportAll', 'LeaderController@exportAll');
    Route::post('/leader/deleteAll', 'LeaderController@deleteAll');

    // 班主任管理
    Route::Resource('classTeacher', 'ClassTeacherController');
    Route::post('/classTeacher/upload', 'ClassTeacherController@upload');
    Route::post('/classTeacher/export', 'ClassTeacherController@export');
    Route::post('/classTeacher/exportAll', 'ClassTeacherController@exportAll');
    Route::post('/classTeacher/deleteAll', 'ClassTeacherController@deleteAll');

    // 教研组长管理
    Route::Resource('department', 'DepartmentController');
    Route::post('/department/upload', 'DepartmentController@upload');
    Route::post('/department/export', 'DepartmentController@export');
    Route::post('/department/exportAll', 'DepartmentController@exportAll');
    Route::post('/department/deleteAll', 'DepartmentController@deleteAll');


});
