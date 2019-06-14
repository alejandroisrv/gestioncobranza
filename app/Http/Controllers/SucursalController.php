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
        $sucursal= new Sucursal($request->all());
        $sucursal->encargado_id=1;
        $sucursal->municipio_id=1;
        $sucursal->save();

    }   
    
}
