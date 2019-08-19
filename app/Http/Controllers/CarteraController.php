<?php

namespace App\Http\Controllers;

use DB;
use App\Cliente;
use App\AcuerdoPago;
use Illuminate\Http\Request;

class CarteraController extends Controller
{

    public function getAll(Request $request){
        $data = $request->all();
        $ruta = $data['ruta'];
        $rutaName = DB::table('rutas')->select('nombre')->where('id',$ruta)->first();
        $cartera = Cliente::with(['municipio','pagos_clientes','venta','venta.acuerdo_pago','venta.productos_venta'])
        ->where('ruta',$ruta)
        ->paginate(25);

        return response()->json(['body'=> $cartera,'ruta'=> $rutaName ], 200);

    }


    public function getMorosos(Request $request){

      $acuerdos = AcuerdoPago::with(['cliente'])
      ->where('cuotas','>','cuotas_pagadas')
      ->where('updated_at','>',date('Y-m-d', strtotime("-30 days")))
      ->get();

      $acuerdos->map(function($item){
        $item->deuda = $item->monto/($item->cuotas-$item->cuotas_pagadas);
      });

      return response()->json(['body'=>$acuerdos]);


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cartera  $cartera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cartera $cartera)
    {
        //
    }
}
