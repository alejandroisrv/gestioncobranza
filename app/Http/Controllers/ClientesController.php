<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientesController extends Controller
{


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

    public function create(Request $request)
    {
        $cliente = new Cliente($request->all());
        $cliente->sucursal_id=1;
        $cliente->save();


        return $cliente;

    }


    public function pagos_clientes(Request $request)
    {
       
        


    }

    public function getMorosos(Request $request ){
        $data = $request->all();

        $clientes = Cliente::with(['sucursal','acuerdos_pagos','pagos_clientes'])
        ->whereHas('acuerdos_pagos', function($q){
            return $q->whereDate('finished_at','>=', Carbon::now() );
        })->paginate(20);


    }


    public function update(Request $request,$id)
    {
        $cliente=Cliente::find($id);
        $cliente->update($request->all());
    }

    public function destroy(Request $request,$id)
    {
         return Cliente::destroy($id);
    }
}
