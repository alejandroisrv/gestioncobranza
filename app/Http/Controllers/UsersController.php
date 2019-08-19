<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function getUsers(Request $request){
      $data = $request->all();
      $bodega = (isset($data['bodega'])) ? $data['bodega'] : null;
      $users = User::with('ventas')
      ->where('sucursal_id',$request->user()->sucursal_id)
      ->where(function($q)use($bodega){
          return ($bodega!==null) ? $q->where('bodega_id',$bodega) : $q ;
      })->get();

      return response()->json(['data'=> $users]);
    }

    public function changePassword(Request $request){
      $data = $request->all();
      try {

        $id = $request->user()->id;
        $user = User::find($id);

        if (Hash::check($data['password'], $user->password)){
            $user->password = bcrypt($data['newPassword']);
            $user->save();
            return response()->json(['response' => true],201);
        }

        return response()->json(['response'=> false ]);

      } catch (\Exception $e) {
          return response()->json(['error'=> $e->getMessage()],422);
      }


    }
}
