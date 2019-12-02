<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\User;
use Illuminate\Http\Request;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){

    }
    public function index(Request $request)
    {

      $sucursal_id = $request->user()->sucursal_id;

      $bodegas=Bodega::with(['sucursal','municipio'])
      ->where('sucursal_id',$sucursal_id)
      ->paginate(20);

      return response()->json(['body'=> $bodegas]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create(Request $request)
    {   $data = $request->all();
        $bodega = new Bodega($request->all());
        $bodega->sucursal_id=$request->user()->sucursal_id;
        $bodega->encargado_id=$data['encargado']['id'];
        $bodega->save();
        return $bodega;
    }

    public function update(Request $request,$id)
    {
        $bodega = Bodega::find($id)->update([
            'encargado_id'=> $request->encargado_id,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'municipio_id' => $request->municipio_id
        ]);
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
