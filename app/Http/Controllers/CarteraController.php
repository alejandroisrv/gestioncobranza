<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class CarteraController extends Controller
{

    public function getAll(Request $request){
        $data = $request->all();
        $ruta = $data['ruta'];
        
        
        $cartera = Cliente::with(['municipio','pagos_clientes','venta','venta.acuerdo_pago','venta.productos_venta'])
        ->where('ruta',$ruta)
        ->paginate(25);
        
        return response()->json(['body'=> $cartera ], 200);

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
