<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->sucursal_id;
        $trabajadores = User::where('sucursal_id',$sucursal_id )->count();
        $clientes =  Clientes::where()->count();
        $rutas = Ruta::where('sucursal_id',$sucursal)->count();
        $productos = Productos::count();
        $bodegas= Bodegas::where('sucursal_id',$sucursal)->count();
        $cartera = AcuerdoPago::where('cuotas','>','cuotas_pagadas')->paginate(20);
        $total = 0;
        $cartera->map(function($item){
            $total += ($item->cuotas- $item->cuotas_pagadas) * ($item->monto / $item->cuotas);
        });
        $carteraMora = $total;
        
        $datos = ['cartera'=> $carteraMora, 'bodegas'=> $cartera,'productos'=> $productos, 
                  'clientes' => $clientes, 'rutas'=> $rutas ];
        $graficos = [];

        
        return response()->json(['body'=> $datos,'graficos'=> $graficos ]);
        

    }

}
