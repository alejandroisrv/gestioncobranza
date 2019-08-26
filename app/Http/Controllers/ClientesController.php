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
        $nombre = isset($data['buscar']) ? $data['buscar'] : null ;
        $codigo = isset($data['buscar']) ? $data['buscar'] : null ;
        $sucursal= isset($request->user()->sucursal_id) ? $request->user()->sucursal_id : null ;
        $clientes = Cliente::with(['sucursal','municipio','acuerdos_pagos','pagos_clientes','ruta_items.ruta'])
        ->where(function($q) use($codigo){
            return ($codigo !== null) ? $q->where('codigo',$codigo ) : $q ;
        })
        ->where(function($q) use($direccion){
            return ($direccion!==null) ? $q->where('direccion','like', '%'.$direccion.'%') : $q ;
        })
        ->where(function($q) use($nombre){
            return ($nombre != null) ? $q->where('nombre','like', '%'.$nombre.'%') : $q ;
        })
        ->where(function($q) use($municipio){
            return ($municipio != null) ? $q->where('municipio_id', $municipio) : $q ;
        })
        ->where(function($q) use($ruta){
            return ($ruta!=null) ? $q->where('ruta', $ruta) : $q ;
        })
        ->where('sucursal_id',$sucursal)
        ->paginate(25);
        $clientes->map(function($item){
            $item['select']=false;
        });
        $datos_buscados =[];
        return response()->json(['body'=>$clientes,'datos_buscados'=> $datos_buscados]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        try {
            
            $cliente = Cliente::create([
                'sucursal_id' => $user->sucursal_id,
                'nombre'=> $data['nombre'],
                'cedula' => $data['cedula'],
                'telefono'  => $data['telefono'],
                'direccion'  => $data['direccion'],
                'email' => $data['email'],
                'municipio_id'  => $data['municipio_id']
            ]);
                    
            $cliente->cod = "0{$user->sucursal_id}0{$cliente->id}";
            $cliente->save();

            return response()->json(['response'=>true,'item'=> $cliente]);

        } catch (\Exception $e) {

            return response()->json(['response'=>false, 'error'=> $e->getMessage() ], 422);   

        }

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
        $data = $request->all();

        $cliente=Cliente::find($id)->update([
            'nombre'=> $data['nombre'],
            'cedula' => $data['cedula'],
            'telefono'  => $data['telefono'],
            'direccion'  => $data['direccion'],
            'email' => $data['email'],
            'municipio_id'  => $data['municipio_id']
        ]);

        return response()->json(['response'=>true,'item' => $cliente ],201);
    }

    public function destroy(Request $request,$id)
    {
         return Cliente::destroy($id);
    }
}
