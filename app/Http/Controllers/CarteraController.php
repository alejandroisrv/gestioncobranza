<?php

namespace App\Http\Controllers;

use App\Cartera;
use Illuminate\Http\Request;

class CarteraController extends Controller
{

    public function index(){
        $cartera = AcuerdoPago::where('cuotas','>','cuotas_pagadas')->paginate(20);
        $total = 0;
        $cartera->map(function($item){
            $total += ($item->cuotas- $item->cuotas_pagadas) * ($item->monto / $item->cuotas);
        });

        response()->json(['body'=> $cartera,'total'=> $total]);


        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cartera  $cartera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cartera $cartera)
    {
        //
    }
}
