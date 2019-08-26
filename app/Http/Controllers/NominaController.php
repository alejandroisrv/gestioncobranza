<?php

namespace App\Http\Controllers;


use App\ComisionVenta;
use App\User;
use App\Role;
use Validator;
use Illuminate\Http\Request;

class NominaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=$request->all();

        $rol     = isset($data['rol']) ? $data['rol'] : null;
        $sucursal= isset($data['sucursal']) ? $data['sucursal'] : null;
        $limite  = isset($data['limite']) ? $data['limite'] : 10 ;
        $buscar  = isset($data['buscar']) ? $data['buscar'] : null;

        $trabajadores= User::with(['rol','comisiones','sucursal','bodega'])
        ->where(function($q) use($buscar) {
            return ($buscar !== null) ? $q->where('name','like','%'.$buscar.'%')->orWhere('email',$buscar) :$q ;
        })
        ->where(function($q) use($sucursal) {
              return ($sucursal !== null) ? $q->where('sucursal_id',$sucursal) :$q ;
          })
          ->paginate($limite);


        return response()->json(['body'=>$trabajadores]);

    }

    public function create(Request $request){

        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'string|required',
            'cedula' => 'string|required',
            'direccion' => 'string|required',
            'telefono' => 'string|required',
        ]);

        if ($validator->fails()) {
            return response()->json(['response' => $validator->errors()], 422);
        }

        $trabajador = User::create([
            'sucursal_id'=>$data['sucursal_id'],
            'bodega_id'=>$data['bodega_id'],
            'name' => $data['name'],
            'cedula' => $data['cedula'],
            'direccion' =>$data['direccion'],
            'telefono' =>$data['telefono'],
            'email' => $data['email'],
            'correo' => @$data['correo'],
            'role' =>$data['role'],
            'password' => bcrypt('123456'),
            'api_token'=>0
        ]);

        return response()->json(['response'=> 'ok']);


    }


    public function edit(Request $request)
    {

        $data=$request->all();

        $usuario=$data['id'];
        $trabajador=User::find($usuario)->update($data);

        return response()->json(['response'=> 'ok']);

    }

    public function delete($id){

        $usuario=$id;
        $trabajador=User::find($usuario);
        $trabajador->delete();
        return response()->json(['response'=> 'ok']);


    }

    public function roles(){
        return Role::all();
    }

}
