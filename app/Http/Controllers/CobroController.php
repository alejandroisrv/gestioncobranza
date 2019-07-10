<?php

namespace App\Http\Controllers;

use App\Cobro;
use App\CobroJornada;
use App\AcuerdoPago;
use Illuminate\Http\Request;

class CobroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $data = $request->all();
        $cliente = isset($data['cliente']) ? $data['cliente']: null ;
        $cobrador = isset($data['cobrador']) ? $data['cobrador']: null ;
        $ruta = isset($data['ruta']) ? $data['ruta']: null ;
        $municipio = isset($data['municipio']) ? $data['municipio']: null ;
        $desde = isset($data['desde']) ? $data['desde']: null ;
        $hasta = isset($data['hasta']) ? $data['hasta']: null ;
        $load = ['cobrador','ruta','cliente','items.cliente','cobros.acuerdo_pagos'];
        $cobros = Cobro::with($loads)
        ->whereHas('ruta', function($q) use($municipio){
            return ($municipio !== null) ? $q->where('municipio_id',$municipio) :  $q;
        })
        ->whereHas('items', function($q) use($cliente){
            return ($cliente !== null) ? $q->where('cliente_id',$cliente) :  $q;
        })
        ->where(function($q)use($desde){
            return ($desde !== null) ? $q->whereDate('fecha_inicio','>=',$desde) :  $q;
        })
        ->where(function($q)use($hasta){
            return ($hasta !== null) ? $q->whereDate('fecha_inicio','<=',$hasta) :  $q;
        })
        ->where(function($q)use($cobrador){
            return ($cobrador !== null) ? $q->where('cobrador_id',$cobrador) :  $q;
        })
        ->where(function($q)use($ruta){
            return ($ruta !== null) ? $q->where('ruta_id',$ruta) :  $q;
        })
        ->orderBy('fecha_inicio','DESC')
        ->paginate(20);

        
     
        $datos_buscados = [];
        return response()->json(['body'=> $cobros , 'datos_buscados'=> $datos_buscados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $jornada = Cobro::create([
            'cobrador_id' => $data['cobrador'], 
            'ruta_id' => $data['ruta']['id'] ,
            'fecha_inicio' => $data['fecha_inicio']
        ]);
        for ($i=0; $i < count($data['ruta']['items']) ; $i++) { 
            $acuerdo_pagos = AcuerdoPago::where('cliente_id', $data['ruta']['items'][$i]['cliente_id'])->where('estado',0)->get();
            foreach($acuerdo_pagos as $acuerdo){
                CobroJornada::create([
                    'cobro_id'=> $jornada->id,
                    'ruta_item_id' => $data['ruta']['items'][$i]['id'],
                    'acuerdo_pago_id' => $acuerdo->id,
                ]);
            }

        }

        return $jornada;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cobro $cobro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cobro $cobro)
    {
        //
    }
}
