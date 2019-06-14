<?php

namespace App\Http\Controllers;

use App\Bodega;
use Illuminate\Http\Request;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        
    }
    public function index()
    {
        $id=1;
        $bodegas=Bodega::with('sucursal')->whereHas('sucursal', function($q)use($id){
            $q->where('id',$id);
        })->get();

        return response()->json($bodegas);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $bodega = new Bodega($request->all());
        $bodega->sucursal_id=1;
        $bodega->encargado_id=1;
        $bodega->save();
        return $bodega;
    }

    public function update(Request $request,$id)
    {
        $bodega = Bodega::find($id);
        $bodega->update($request->all());

        $bodega->save();
        return $bodega;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        return Bodega::destroy($id);
    }
}
