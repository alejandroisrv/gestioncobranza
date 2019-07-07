<?php

namespace App\Http\Controllers;
use App\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{

    public function index(Request $request){
        return Sucursal::with('municipio')->get();
    }
    public function create(Request $request){
        $data=$request->all();
        $sucursal= new Sucursal($data);
        $sucursal->encargado_id=$data['encargado']['id'];
        $sucursal->save();
        return $sucursal;
    }
    

    public function destroy(Request $request,$id){
        $data=$request->all();
        Sucursal::destroy($id);
    }
}
