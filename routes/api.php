<?php


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

//Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout');

Route::get('courses/{course}/managers', 'CourseController@managers');

Route::get('managers/{manager}/groups', 'GroupManagerController@courses');
Route::delete('managers/{manager}', 'GroupManagerController@destroy');
Route::post('managers', 'GroupManagerController@store');

Route::get('groups/{group}', 'StudentGroupController@show');
Route::delete('groups/{group', 'StudentGroupController@destroy');
Route::post('groups', 'StudentGroupController@store');