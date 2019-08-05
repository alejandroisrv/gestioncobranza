<?php

namespace App\Http\Controllers;

use DB;
use App\Cliente;
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
