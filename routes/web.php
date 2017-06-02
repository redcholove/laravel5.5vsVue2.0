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

Route::post('/getall', 'Controller@getall');
Route::post('/test', 'Controller@test');
Route::post('/buy', 'Controller@buy');
Route::post('/test1', 'Controller@test1');
