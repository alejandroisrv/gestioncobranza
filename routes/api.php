<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/example','ExampleController@show');
Route::post('/example','ExampleController@create');

Route::get('/producto/{id}','ProductosController@getProducto');
Route::post('/producto/update/{id}','ProductosController@update');
Route::get('/producto/delete/{id}','ProductosController@destroy');
Route::post('/producto','ProductosController@create');
Route::get('/productos','ProductosController@index');

Route::get('/clientes','ClientesController@index');
Route::post('/cliente/add','ClientesController@create');
Route::post('/clientes/update/{id}','ClientesController@update');
Route::get('/cliente/delete/{id}','ClientesController@destroy');


Route::get('/bodegas','BodegaController@index');
Route::post('/bodega','BodegaController@create');
Route::post('/bodegas/update/{id}','BodegaController@update');
Route::get('/bodega/delete/{id}','BodegaController@destroy');

Route::get('/ventas','BodegaController@index');
Route::post('/venta','BodegaController@create');