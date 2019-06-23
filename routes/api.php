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
Route::get('/datos-usuarios' ,function(Request $request){
    return $request->user();
});


Route::group(['middleware' => 'auth:api'], function () {
  Route::get('/example','ExampleController@show');
  Route::post('/example','ExampleController@create');

  Route::post('/producto','ProductosController@create');
  Route::get('/productos','ProductosController@index');
  Route::get('/producto/{id}','ProductosController@getProducto');
  Route::post('/producto/update/{id}','ProductosController@update');
  Route::get('/producto/delete/{id}','ProductosController@destroy');
  Route::post('/producto/abastecer','ProductosController@abastecer');
  Route::post('/producto/entregar','ProductosController@entregar');


  Route::get('/clientes','ClientesController@index');
  Route::post('/cliente/add','ClientesController@create');
  Route::post('/clientes/update/{id}','ClientesController@update');
  Route::get('/cliente/delete/{id}','ClientesController@destroy');

  Route::get('/bodegas','BodegaController@index');
  Route::post('/bodega','BodegaController@create');
  Route::post('/bodegas/update/{id}','BodegaController@update');
  Route::get('/bodega/delete/{id}','BodegaController@destroy');

  Route::get('/ventas','VentasController@index');
  Route::get('/ventas/tipos','VentasController@getTipos');
  Route::post('/ventas','VentasController@create');

  Route::get('/sucursales','SucursalController@index');
  Route::post('/sucursal','SucursalController@create');
  Route::post('/sucursales/update/{id}','SucursalController@update');
  Route::get('/sucursal/delete/{id}','SucursalController@destroy');


  Route::get('/municipios','MunicipioController@index');

  Route::get('users/all', 'UsersController@getUsers');

});
