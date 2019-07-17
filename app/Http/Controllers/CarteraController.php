<?php

namespace App\Http\Controllers;

use App\Cartera;
use Illuminate\Http\Request;

class CarteraController extends Controller
{

    public function index()
    {
        $cartera = AcuerdoPago::where('cuotas','>','cuotas_pagadas')->paginate(20);
        $total = 0;
        $cartera->map(function($item){
            $total += ($item->cuotas- $item->cuotas_pagadas) * ($item->monto / $item->cuotas);
        });

        response()->json(['body'=> $cartera,'total'=> $total]);


        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cartera  $cartera
     * @return \Illuminate\Http\Response
     */
    public function show(Cartera $cartera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cartera  $cartera
     * @return \Illuminate\Http\Response
     */
    public function edit(Cartera $cartera)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cartera  $cartera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cartera $cartera)
    {
        //
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
