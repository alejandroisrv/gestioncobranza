<?php

namespace App\Http\Controllers;

use App\ContabilidadCategoria;
use App\Contabilidad;
use Illuminate\Http\Request;

class ContabilidadController extends Controller
{

    public function add(Request $request){

        $data = $request->all();
        $tipo = isset($data['tipo']['id']) ? $data['tipo']['id'] : null;
        
        if($tipo == null || $tipo == 0 ){
            return response(['response'=> 'Tipo no definido'], 422);
        }

        $Contabilidad = Contabilidad::create([
            'user_id'=> auth()->user()->id,
            'descripcion'=> $data['descripcion'],
            'monto' => $data['monto'],
            'tipo'=> $data['tipo']['id']
        ]);
    
        return response()->json($Contabilidad, 201);

    }

    public function getAll(Request $request){
        $data  = $request->all();

        $tipo = isset($data['tipo']) ? $data['tipo'] : null ;
        $desde = isset($data['desde']) ? $data['desde'] : null ;
        $hasta = isset($data['hasta']) ? $data['hasta'] : null ;


        if($desde != null) {
            $desde = explode('/', $desde);
            $desde = $desde[2].'-'.$desde[1].'-'.$desde[0];
        }

        if($hasta != null) {
            $hasta = explode('/', $hasta);
            $hasta = $hasta[2].'-'.$hasta[1].'-'.$hasta[0];
        }


        $Contabilidad = Contabilidad::with(['type','usuario'])
        ->where(function($q) use($tipo) {
            return ($tipo !== null) ? $q->where('tipo',$tipo) : $q ;
        })
        ->where(function($q) use($desde) {
            return ($desde !== null) ? $q->whereDate('created_at','>=',$desde) : $q ;
        })
        ->where(function($q) use($hasta) {
            return ($hasta !== null) ? $q->whereDate('created_at','<=',$hasta) : $q ;
        })
        ->orderBy('created_at','DESC')
        ->paginate(25);

        return response()->json(['body'=> $Contabilidad]);


    }

    public function getCategorias(Request $request){

        $data = $request->all();

        $categorias = ContabilidadCategoria::all();
        $categorias->load('transacciones');
        $category = [];
        foreach ($categorias as $c) {
            if($c->id != 1 && $c->id !=2){
                array_push($category,['id' => $c->id, 'label'=>$c->descripcion,
                                      'operacion' => ['id' => $c->operacion,'label' => $c->operacion == 1 ? 'Abono': 'Cargo'],
                                      'transacciones' => $c->transacciones,'delete'=> !(count($c->transacciones)>0)
                                      ]);
            }
        }

        return response()->json($category,200);
    
    }

    public function createCategoria(Request $request){
        
        $data = $request->all();
        $categoria = ContabilidadCategoria::create(['descripcion' => $data['descripcion'], 'operacion' => $data['operacion']['id']]);
        return response()->json($categoria,201);
    }


    public function updateCategoria(Request $request){
        $data = $request->all();
        $categoria = ContabilidadCategoria::find($data['id']);
        $categoria->descripcion = $data['label'];
        $categoria->operacion = $data['operacion']['id']; 
        $categoria->save();
        return response()->json($categoria, 201);

    }

    public function deleteCategoria($id){

        ContabilidadCategoria::destroy($id);
        return response()->json(['response'=> 'ok'], 200);
        

    }
}
