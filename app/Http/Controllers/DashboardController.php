<?php

namespace App\Http\Controllers;
use App\User;
use App\Cliente;
use App\Ruta;
use App\AcuerdoPago;
use App\Bodega;
use App\Productos;
use Carbon\Carbon;
use App\Venta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        setlocale(LC_ALL,"es_ES"); 
        Carbon::setLocale('es');
        $sucursal_id = $request->user()->sucursal_id;
        $trabajadores = User::where('sucursal_id',$sucursal_id )->count();
        $clientes =  Cliente::where('sucursal_id',$sucursal_id )->count();
        $rutas = Ruta::count();
        $productos = Productos::count();
        $bodegas= Bodega::where('sucursal_id',$sucursal_id)->count();
        $cartera = AcuerdoPago::where('cuotas','>','cuotas_pagadas')->paginate(20);
        $total = 0;
        $cartera->map(function($item)use($total){
            $total += ($item->cuotas- $item->cuotas_pagadas) * ($item->monto / $item->cuotas);
        });
        $carteraMora = $total;
        $pr = ['total'=> $productos, 'color'=>'bg-aqua', 'text'=> 'Productos','title'=> 'Ver productos','link'=>'/inventario','icon'=>'ion ion-bag'];
        $cl = ['total'=> $clientes, 'color'=>'bg-yellow', 'text'=> 'Clientes','title'=> 'Ver Clientes','link'=>'/clientes','icon'=>'ion ion-person'];
        $rt = ['total'=> $rutas, 'color'=>'bg-default', 'text'=> 'Rutas','title'=> 'Ver rutas','link'=>'/rutas','icon'=>'ion ion-map'];
        $tr = ['total'=> $trabajadores, 'color'=>'bg-green', 'text'=> 'Empleados','title'=> 'Ver empleados','link'=>'/nomina','icon'=>'ion ion-'];
        $bg = ['total'=> $bodegas, 'color'=>'bg-primary', 'text'=> 'Bodegas','title'=> 'Ver bodegas','link'=>'/bodegas','icon'=>'ion ion-home'];
        $ct = ['total'=> $carteraMora, 'color'=>'bg-red', 'text'=> 'Cartera en mora','title'=> 'Ver Catera','link'=>'/cartera','icon'=>'ion ion-pie-graph'];
        
        $datos = [$pr,$cl,$rt,$tr,$bg,$ct];
        $graficos = Venta::select('total')->where('created_at','>=',Carbon::now()->subWeek(1)->toDateTimeString())->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('D'); // grouping by years
           
        });

        
        return response()->json(['body'=> $datos,'graficos'=> $graficos,'carbon'=>Carbon::now()->subWeek(1)->toDateTimeString()]);
        

    }

}
