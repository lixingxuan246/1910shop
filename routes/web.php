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
Route::get('/user/reg', function () {
    return view('reg');
});


Route::post('user/reg','RegController@index');
Route::post('user/login','LoginController@index');
Route::get('/user/login', function () {
    return view('login');
});

Route::post('api/user/reg','Api\UserController@reg');
Route::post('api/user/login','Api\UserController@login');

//jjjjjjjj
