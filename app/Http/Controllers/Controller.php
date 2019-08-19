<?php

namespace App\Http\Controllers;


use App\Movimiento;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $user;
    public $sucursal;
    public $bodega;

    public function addTransitions($description,$tipo,$monto){

        $Contabilidad = Contabilidad::create([
            'user_id'=> auth()->user()->id,
            'descripcion'=> $descripcion,
            'monto' => $monto,
            'tipo'=> 1
        ]);

        return true;
    }

    public function addHistory($producto,$cantidad,$operacion,$descripcion,$user){

        $movimiento = Movimiento::create([
            'producto_id' => $producto,
            'user_id' => auth()->user()->id,
            'cantidad'=> $cantidad,
            'operacion'=> $operacion,
            'descripcion' => $descripcion,
        ]);

        if(!$movimiento){
            return false;
        }

        return true;

    }
}
