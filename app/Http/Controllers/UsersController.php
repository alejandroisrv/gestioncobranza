<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

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
}
