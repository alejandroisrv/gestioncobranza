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
Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/dashboard', 'HomeController@index')->middleware('auth');
Route::get('/inventario', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/bodegas', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/clientes', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/ventas', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/sucursales', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/contabilidad', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/cobranza', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/rutas', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/morosos', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/auth/logout', 'Auth\LoginController@logout')->name('logout')->middleware('guest');
