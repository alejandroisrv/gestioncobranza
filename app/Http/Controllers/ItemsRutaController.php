<?php

namespace App\Http\Controllers;

use App\Ruta;
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
        $ruta = Ruta::create([ 'municipio_id' => $data['municipio']['id'], 'nombre' =>  $data['nombre']]);
        for ($i=0; $i < count($data['seleccionados']); $i++) { 
            RutaItem::create(['ruta_id'=> $ruta->id, 'cliente_id' => $data['seleccionados'][$i]['id'], 'orden' => $i+1 ]);
        }

        return response()->json($ruta);

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
     * @param  \App\Ruta  $ruta
     * @return \Illuminate\Http\Response
     */
    public function show(Ruta $ruta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ruta  $ruta
     * @return \Illuminate\Http\Response
     */
    public function edit(Ruta $ruta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ruta  $ruta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ruta $ruta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ruta  $ruta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        Ruta::destroy($id);
    }
}
