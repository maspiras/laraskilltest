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

Auth::routes();
Route::get('/home', 'HomeController@index');

Route::match(['get', 'post'], '/', 'MainCtrl@index');
Route::match(['get', 'post'], '/{p1}', 'MainCtrl@index');
Route::match(['get', 'post'], '/{p1}/{p2}', 'MainCtrl@index');
Route::match(['get', 'post'], '/{p1}/{p2}/{p3}', 'MainCtrl@index');
Route::match(['get', 'post'], '/{p1}/{p2}/{p3}/{p4}', 'MainCtrl@index');
Route::match(['get', 'post'], '/{p1}/{p2}/{p3}/{p4}/{p5}', 'MainCtrl@index');
Route::match(['get', 'post'], '/{p1}/{p2}/{p3}/{p4}/{p5}/{p6}', 'MainCtrl@index');
Route::match(['get', 'post'], '/{p1}/{p2}/{p3}/{p4}/{p5}/{p6}/{p7}', 'MainCtrl@index');

