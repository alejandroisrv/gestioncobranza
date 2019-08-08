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
        $limite  = isset($data['limite']) ? $data['limite'] : 20 ;
        
        $trabajadores= User::with(['roles','comisiones'])->where(function($q) use($sucursal) {
                return ($sucursal!==null) ? $q->where('sucursal_id',$sucursal) :$q ;
            })->paginate($limite);
    
     
        return response()->json(['body'=>$trabajadores]);

    }

    
    public function getData(Request $request){
        $data = $request->all();


    }


    public function create(Request $request)
    {
        
        $data = $request->all();
 
        $validator = Validator::make($data, [
            'name' => 'string|required',
            'cedula' => 'string|required',
            'direccion' => 'string|required',
            'telefono' => 'string|required',
            'email' => 'string|required',
        ]);
        

        if ($validator->fails()) {
            return response()->json(['response' => $validator->errors()], 422);
        }
        $role = Role::where('slug',$data['rol']['slug'])->first();
        $trabajador = User::create([
            'name' => $data['name'],
            'cedula' => $data['cedula'],
            'direccion' =>$data['direccion'],
            'telefono' =>$data['telefono'],
            'email' => $data['email'],
            'api_token'=>0
        ]);
        $trabajador->roles()->attach($role);


        return response()->json(['response'=> 'ok']);
    }


    public function edit(Request $request)
    {
        $data=$request->all();
        $usuario=$data['id'];
        $trabajador=User::find($usuario)->update($data);
        $trabajador->roles()->detach();
        $trabajador->roles()->attach($rol);

        return response()->json(['response'=> 'ok']);
        

    }

    public function delete($id){
        $usuario=$id;
        $trabajador=User::find($usuario);
        $trabajador->roles()->detach();
        $trabajador->delete();

        return response()->json(['response'=> 'ok']);
    }

    public function roles(){
        return Role::all();
    }

}
