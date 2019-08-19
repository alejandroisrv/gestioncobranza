<?php

namespace App\Http\Controllers;

use App\PagoCliente;
use Validator;
use Illuminate\Http\Request;

class PagoClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $data=$request->all();
        $limite = (isset($data['limite'])) ? : 20 ;
        $pagos_clientes = PagoCliente::with()->paginate($limite);
        return response()->json(['body' => $pago_cliente]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'bail|required',
            'venta_id' => 'bail|required',
            'monto' => 'bail|required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        $pago_cliente = PagoCliente::create([
            'cliente_id'=> $data['cliente_id'],
            'venta_id'=> $data['venta_id'] ,
            'monto' => $data['monto'] ,
        ]);


        return response()->json(['response' => 'ok']);
    }

    public function edit(PagoCliente $pagoCliente)
    {
     

    }

  
    public function update(Request $request, $id)
    {

    


    }

}
