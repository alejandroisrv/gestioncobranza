<?php

namespace App\Http\Controllers;
use DB;
use Validator;
use App\Ruta;
use App\Cliente;
use App\RutaItem;
use Illuminate\Http\Request;

class ItemsRutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $municipio = isset($data['municipio']) ? $data['municipio'] : null ;
        $rutas = Ruta::with('items','items.cliente','municipio')
        ->where(function($q) use($municipio){
            return ($municipio!=null) ? $q->where('municipio_id',$municipio) : $q ;
        })->paginate(25);

        $datos_buscados = ['municipio'=> $municipio];
        return response()->json(['body' => $rutas,'datos_buscados'=> $datos_buscados ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data=$request->all();
        $sucursal = $request->user()->sucursal_id;
        $validator = Validator::make($data, [
            'municipio.id' => 'integer|required',
            'nombre' => 'string|required',
            'seleccionados' => 'array|required',
        ]);

        if ($validator->fails()) {
            return response()->json(['response' => $validator->errors()], 422);
        }

        $ruta = Ruta::create([ 'sucursal_id' => $sucursal,'municipio_id' => $data['municipio']['id'], 'nombre' =>  $data['nombre']]);
        for ($i=0; $i < count($data['seleccionados']); $i++) {
            Cliente::where('id',$data['seleccionados'][$i]['id'])->update('ruta',$ruta->id);
            RutaItem::create(['ruta_id'=> $ruta->id, 'cliente_id' => $data['seleccionados'][$i]['id'], 'orden' => $i+1 ]);
        }

        return response()->json(['response'=>'ok']);

    }


    public function update(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'integer|required',
            'municipio.id' => 'integer|required',
            'nombre' => 'string|required',
            'seleccionados' => 'array|required',
        ]);

        if ($validator->fails()) {
            return response()->json(['response' => $validator->errors()], 422);
        }

        $id = $data['id'];
        $ruta = Ruta::where('id', $id)->update([ 'municipio_id' => $data['municipio']['id'], 'nombre' =>  $data['nombre']]);
        DB::table('ruta_items')->where('ruta_id',$id)->delete();
        $status = 0 ;

        for ($i=0; $i < count($data['seleccionados']); $i++) {
            Cliente::where('id',$data['seleccionados'][$i]['id'])->update(['ruta' => $id]);
            $ruta_item = RutaItem::create(['ruta_id'=> $id, 'cliente_id' => $data['seleccionados'][$i]['id'], 'orden' => $i+1 ]);
            if($ruta_item) {
                $status++;
            }
        }

        if(count($data['seleccionados']) == $status){
            return response()->json(['message' =>'ok']);
        }else{
            return response()->json(['message' =>'error']);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ruta  $ruta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $ruta = Ruta::find($id);
        if($ruta->delete()){
            return response()->json(['message' =>'ok']);
        }else{
            return response()->json(['message' =>'error']);
        }

    }
}
