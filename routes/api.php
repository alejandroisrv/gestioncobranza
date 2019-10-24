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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api'], function () {
  Route::get('/example','ExampleController@show');
  Route::post('/example','ExampleController@create');

  Route::get('/dashboard/all','DashboardController@index');
  Route::post('/producto/add','ProductosController@create');
  Route::get('/productos','ProductosController@index');
  Route::post('/producto/update/{id}','ProductosController@update');
  Route::get('/producto/delete/{id}','ProductosController@destroy');
  Route::post('/producto/abastecer','ProductosController@abastecer');
  Route::post('/producto/entregar','ProductosController@entregar');

  Route::post('/productos/tipo','ProductosController@addTipo');
  Route::get('/productos/tipos','ProductosController@getTipos');
  Route::get('/productos/tipos-list','ProductosController@getTiposList');
  Route::post('/productos/tipo/update','ProductosController@editTipo');
  Route::post('/productos/tipo/delete/{id}','ProductosController@deleteTipos');

  Route::get('/clientes','ClientesController@index');
  Route::post('/cliente/add','ClientesController@create');
  Route::post('/clientes/update/{id}','ClientesController@update');
  Route::get('/cliente/delete/{id}','ClientesController@destroy');

  Route::post('/bodega/add','BodegaController@create');
  Route::get('/bodegas','BodegaController@index');
  Route::post('/bodegas/update/{id}','BodegaController@update');
  Route::get('/bodega/delete/{id}','BodegaController@destroy');

  Route::get('/ventas','VentasController@index');
  Route::get('/ventas/tipos','VentasController@getTipos');
  Route::post('/ventas','VentasController@create');

  Route::get('/sucursales','SucursalController@index');
  Route::post('/sucursal/add','SucursalController@create');
  Route::post('/sucursales/update/{id}','SucursalController@update');
  Route::get('/sucursal/delete/{id}','SucursalController@destroy');


  Route::get('/acuerdos_pagos','AcuerdosPagoController@index');
  Route::post('/acuerdos_pagos','AcuerdosPagoController@create');
  Route::get('/acuerdo_pago/{id}','AcuerdosPagoController@get');
  Route::post('/acuerdos_pagos/nuevo-pago','AcuerdosPagoController@nuevoPago');
  Route::post('/pagos_clientes','PagoClienteController@index');
  Route::post('/pagos_clientes','PagoClienteController@create');

  Route::get('/nomina/all','NominaController@index');
  Route::get('/nomina/roles/all','NominaController@roles');
  Route::post('/nomina/add','NominaController@create');
  Route::post('/user/change-password','UsersController@changePassword');
  Route::post('/nomina/edit','NominaController@edit');
  Route::post('/nomina/delete/{id}','NominaController@delete');

  Route::get('/comisiones','ComisionVentaController@index');
  Route::get('/comisiones/pagar/{id}','ComisionVentaController@pay');

  Route::get('/rutas','ItemsRutaController@index');
  Route::post('/rutas/add','ItemsRutaController@create');
  Route::post('/rutas/update','ItemsRutaController@update');
  Route::get('/rutas/delete/{id}','ItemsRutaController@destroy');

  Route::get('/cobros','CobroController@index');
  Route::post('/cobros/add','CobroController@create');

  Route::get('/municipios','MunicipioController@index');
  Route::post('/municipio','MunicipioController@create');
  Route::post('/municipio/update','MunicipioController@update');
  Route::post('/municipio/delete/{id}','MunicipioController@delete');
  
  
  Route::get('users/all', 'UsersController@getUsers');



  Route::get('/contabilidad/all', 'ContabilidadController@getAll');
  Route::post('/contabilidad/add', 'ContabilidadController@add');
  Route::get('/contabilidad/categorias', 'ContabilidadController@getCategorias');
  Route::post('/contabilidad/categoria', 'ContabilidadController@createCategoria');
  Route::post('/contabilidad/categoria/edit', 'ContabilidadController@updateCategoria');
  Route::post('/contabilidad/categoria/delete/{id}', 'ContabilidadController@deleteCategoria');

  Route::get('/cartera/all', 'CarteraController@getAll');
  Route::get('/morosos/all', 'CarteraController@getMorosos');

  Route::get('/movimientos/all','MovimientosController@get');

  Route::get('/reportes/all','ReportesController@get');


});
