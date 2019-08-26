<?php

namespace App\Http\Controllers;

use App\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $municipios= Municipio::withCount(['sucursales','clientes','bodegas'])->paginate(25);
        return response()->json(['body'=>$municipios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $data = $request->all();

        $municipio = Municipio::create([
          'municipio' => $data['municipio']
        ]);

        return response()->json($municipio,201);
    }


    public function update(Request $request){
        $data = $request->all();
        $municipio = Municipio::find($data['id'])->update([
          'municipio' => $data['municipio']
        ]);

        return response()->json($municipio,201);

    }

    public function delete($id){
        $municipio = Municipio::find($id);
        if($municipio){
            $municipio->delete();
            return response()->json(['response'=>true],201);
        }
        return response()->json(['response'=> false], 422);
    }

}
