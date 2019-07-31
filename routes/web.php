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


Route::get('/login','Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::get('/auth/logout', 'Auth\LoginController@logout')->name('logout')->middleware('guest');
Route::post('/login','Auth\LoginController@login');  

Route::group(['middleware' => 'auth' ], function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/inventario', 'HomeController@index')->name('home');
    Route::get('/bodegas', 'HomeController@index')->name('home');
    Route::get('/clientes', 'HomeController@index')->name('home');
    Route::get('/ventas', 'HomeController@index')->name('home');
    Route::get('/sucursales', 'HomeController@index')->name('home');
    Route::get('/contabilidad', 'HomeController@index')->name('home');
    Route::get('/cobranza', 'HomeController@index')->name('home');
    Route::get('/rutas', 'HomeController@index')->name('home');
    Route::get('/morosos', 'HomeController@index')->name('home');
    Route::get('/nomina', 'HomeController@index')->name('home');
    Route::get('/comisiones', 'HomeController@index')->name('home');
    Route::get('/cobros', 'HomeController@index')->name('home');
    Route::get('/acuerdos', 'HomeController@index')->name('home');
    Route::get('/contabilidad', 'HomeController@index')->name('home');

});




