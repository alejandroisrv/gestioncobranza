<?php

namespace App\Http\Controllers;
use App\AcuerdoPago;

use Illuminate\Http\Request;

class AcuerdosPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $data= $request->all();
        $cliente = (isset($data['cliente'])) ? $data['cliente']: null ;
        $venta = (isset($data['venta'])) ? $data['venta']: null ;
        $limite = (isset($data['limite'])) ? $data['limite'] : 20 ;
        $acuerdos_pagos= AcuerdoPago::with(['clientes','ventas','pagos_clientes'])
        ->where(function($q) use ($cliente) {
            return ($cliente!=null) ? $q->where('cliente_id',$cliente): $q; 
        })
        ->where(function($q) use ($venta) {
            return ($venta!=null) ? $q->where('venta_id',$venta): $q; 
        })->paginate($limite);
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
