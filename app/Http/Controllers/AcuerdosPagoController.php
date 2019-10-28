<?php

namespace App\Http\Controllers;

use App\AcuerdoPago;
use App\PagoCliente;

use Illuminate\Http\Request;

class AcuerdosPagoController extends Controller
{
    /**
     * D
     * isplay a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $data= $request->all();
        $cliente = (isset($data['cliente'])) ? $data['cliente']: null ;
        $venta = (isset($data['venta'])) ? $data['venta']: null ;
        $limite = (isset($data['limite'])) ? $data['limite'] : 20 ;
        $acuerdos_pagos= AcuerdoPago::with(['cliente','venta.vendedor','venta.tipos_ventas','abonos'=> function($q) { $q->orderBy('venta_id','ASC')->orderBy('created_at','desc'); }])
        ->where(function($q) use ($cliente) {
            return ($cliente!=null) ? $q->where('cliente_id',$cliente): $q; 
        })
        ->where(function($q) use ($venta) {
            return ($venta!=null) ? $q->where('venta_id',$venta): $q; 
        })->paginate($limite);

        $acuerdos_pagos->map(function($acuerdo){
            $saldo = @$acuerdo['abonos'][0]['saldo'];
            $acuerdo['saldo'] = $saldo !== null ? $saldo : $acuerdo->monto;
        });

        return response()->json(['body'=> $acuerdos_pagos ]);
    }

    public function nuevoPago(Request $request){
        $data = $request->all();

        $acuerdo = AcuerdoPago::find($data['acuerdo_id']);
        $acuerdo->load('abonos');
        if(!$acuerdo){
            return response()->json(['response'=> false , 'message'=> "No se ha encontrado el acuerdo de pago"]);
        }

        $montosPagados = 0;

        foreach ($acuerdo->abonos as $abono) {
            $montosPagados += $abono->monto;            
        }
        
        $deuda = $acuerdo->monto - $montosPagados;

        $saldo = $deuda - $data['monto'];

        $pago = PagoCliente::create([
            'cliente_id'=> $data['user_id'],
            'venta_id'=> $data['venta_id'],
            'acuerdo_pago_id' => $data['acuerdo_id'],
            'saldo' => $saldo,
            'monto'=> $data['monto']
        ]);

        if($pago){
            
            $acuerdo->cuotas_pagadas++;
            $acuerdo->estado  =  ($saldo > 0) ? 0 : 1;
        
            if($acuerdo->save()){
                return response()->json(['response'=>true],201);
            }
        }

        return response()->json(['response'=>false],422);
    }

    public function getPagos(Request $request){
        
        $data = $request->all();
        $cliente = isset($data['cliente']) ? $data['cliente'] : null  ;
        $venta = isset($data['venta']) ? $data['venta']  : null ;
        $pagos = PagoCliente::with(['cliente','venta'])
        ->where(function($q) use($cliente){
            return $cliente != null ? $q->where('cliente_id',$cliente) : $q ; 
        })
        ->whereHas('venta',function($q) use($venta){
            return $venta != null ? $q->where('cod','like',"%".$venta."%") : $q ; 
        })
        ->orderBy('created_at','DESC')
        ->paginate(10);

        return response()->json(['body'=> $pagos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        


    }

    public function get(Request $request,$id)
    {
        
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
