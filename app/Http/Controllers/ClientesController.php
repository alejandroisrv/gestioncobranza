<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){   
        $data = $request->all();
        $municipio = isset($data['municipio']) ? $data['municipio'] : null ;
        $direccion = isset($data['direccion']) ? $data['direccion'] : null ;
        $ruta = isset($data['ruta']) ? $data['ruta'] : null ;
        $nombre = isset($data['nombre']) ? $data['nombre'] : null ;
        $sucursal= isset($request->user()->sucursal_id) ? $request->user()->sucursal_id : null ;
        $clientes = Cliente::with('sucursal','acuerdos_pagos','pagos_clientes')
        ->where(function($q) use($direccion){
            return ($direccion!==null) ? $q->where('direccion','like', '%'.$direccion.'%') : $q ;
        })
        ->where(function($q) use($nombre){
            return ($nombre!=null) ? $q->where('nombre','like', '%'.$nombre.'%') : $q ;
        })
        ->where(function($q) use($ruta){
            return ($ruta!=null) ? $q->where('ruta', $ruta) : $q ;
        })
        ->where('sucursal_id',$sucursal)->paginate(25); 
        $clientes->map(function($item){
            $item['select']=false;
        });
        $datos_buscados =[];
        return response()->json(['body'=>$clientes,'datos_buscados'=> $datos_buscados]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cliente = new Cliente($request->all());
        $cliente->sucursal_id=1;
        $cliente->save();


        return $cliente;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pagos_clientes(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $cliente=Cliente::find($id);
        $cliente->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
         return Cliente::destroy($id);
    }
}