<?php

namespace App\Http\Controllers;

use App\ContabilidadCategoria;
use App\Contabilidad;
use Illuminate\Http\Request;

class ContabilidadController extends Controller
{
    public function getAll(Request $request){
        $data  = $request->all();

        $tipo = isset($data['tipo']) ? $data['tipo'] : null ;
        $desde = isset($data['desde']) ? $data['desde'] : null ;
        $hasta = isset($data['hasta']) ? $data['hasta'] : null ;


        $Contabilidad = Contabilidad::with('type')
        ->where(function($q) use($tipo) {
            return ($tipo !== null) ? $q->where('tipo',$tipo) : $q ;
        })
        ->where(function($q) use($desde) {
            return ($desde !== null) ? $q->where('created_at','>=',$desde) : $q ;
        })
        ->where(function($q) use($hasta) {
            return ($hasta !== null) ? $q->where('created_at','<=',$hasta) : $q ;
        })
        ->paginate(25);

        return response()->json(['body'=> $Contabilidad]);


    }

    public function getCategorias(Request $request){

        $data = $request->all();

        $categorias = ContabilidadCategoria::all();
        $category = [];
        foreach ($categorias as $c) {
            array_push($category,['id' => $c->id, 'label'=>$c->descripcion,
                                 'operacion' => ['id' => $c->operacion,'label' => $c->operacion == 1 ? 'Abono': 'Cargo'] ]);
        }

        return response()->json($category,200);
    
    }

    public function createCategoria(Request $request){
        
        $data = $request->all();
        $categoria = ContabilidadCategoria::create(['descripcion' => $data['descripcion'], 'operacion' => $data['operacion']]);
        return response()->json([$categoria],201);
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
