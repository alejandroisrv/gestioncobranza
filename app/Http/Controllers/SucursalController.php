<?php

namespace App\Http\Controllers;
use App\Sucursal;
use Illuminate\Http\Request;
use App\User;
class SucursalController extends Controller
{

    public function index(Request $request){
        $sucursales = Sucursal::with('municipio')->paginate(20);
        return response()->json(['body' => $sucursales]);
    }
    public function create(Request $request){

        try {
          $data=$request->all();

          $encargado = User::find($data['encargado']['id']);
          if($encargado){
            $sucursal = Sucursal::create([
              'encargado_id' => $data['encargado']['id'],
              'telefono' => $data['telefono'],
              'direccion' => $data['direccion'],
              'municipio_id' => $data['municipio']
            ]);
            $encargado->sucursal_id = $sucursal->id;
            $encargado->role = 1;
            $encargado->save();
            return response()->json(['body'=> $sucursal ]) ;
          }

          return response()->json(['response'=> false, 'error'=>'Encargado no encontrado']) ;

        } catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage() ]) ;
        }




    }

    public function update(Request $request,$id){
      $data = $request->all();
      $encargado = User::find($data['encargado_id']);

      $sucursal = Sucursal::where('id',$id)->update([
        'encargado_id' => $data['encargado_id'],
        'telefono' => $data['telefono'],
        'direccion' => $data['direccion'],
        'municipio_id' => $data['municipio']['id']
        ]);
        $encargado->sucursal_id = $id;
        $encargado->save();
        return response()->json($sucursal,201);


    }

    public function destroy(Request $request,$id){
        $data=$request->all();
        Sucursal::destroy($id);
    }
}
