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
Route::post('/test', 'LeaderController@export');
Route::middleware('auth:api')->group(function() {
    Route::Resource('admin', 'UserController');
    Route::post('/admin/modify', 'UserController@modify' );
    Route::post('/admin/{id}/reset', 'UserController@reset');
    Route::post('/admin/uploadAvatar', 'UserController@uploadAvatar');
    Route::post('/admin/upload', 'UserController@upload');

    Route::Resource('session', 'SessionController');
    Route::post('/session/upload', 'SessionController@upload');

    Route::Resource('leader', 'LeaderController');
    Route::post('/leader/upload', 'LeaderController@upload');
    Route::post('/leader/export', 'LeaderController@export');
    Route::post('/leader/exportAll', 'LeaderController@exportAll');


    Route::Resource('classTeacher', 'ClassTeacherController');
    Route::post('/classTeacher/upload', 'ClassTeacherController@upload');

    Route::Resource('department', 'DepartmentController');
    Route::post('/department/upload', 'DepartmentController@upload');

    Route::Resource('role', 'RoleController');
    Route::get('getRoles', 'RoleController@getRoles');

    Route::get('/getSession', 'SessionController@getSession');
    Route::get('/getDefaultSession', 'SessionController@getDefaultSession');
    Route::get('/getTeacher', 'TeacherController@getTeacher');
    Route::get('/getTeach', 'TeachController@getTeach');



});
