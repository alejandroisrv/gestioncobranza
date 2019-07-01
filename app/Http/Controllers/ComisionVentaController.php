<?php

namespace App\Http\Controllers;

use App\ComisionVenta;
use Illuminate\Http\Request;

class ComisionVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $limite = isset($data['limite']) ? $data['limite'] : 20 ;
        $venta  = isset($data['venta'])  ? $data['venta'] : null ;
        $vendedor = isset($data['vendedor']) ? $data['vendedor'] : null ;



        $loads=['venta','vendedor'];
        $comisiones = ComisionVenta::with($loads)->where(function($q) use($venta){
            return ($venta!=null) ? $q->where('venta_id',$venta) : $q ; 
        })->where(function($q) use($vendedor){
            return ($vendedor!=null) ? $q->where('user_id',$vendedor) : $q ; 
        })
        ->paginate($limite);

        return response()->json(['body'=>$comisiones]);
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
     * @param  \App\ComisionVenta  $comisionVenta
     * @return \Illuminate\Http\Response
     */
    public function show(ComisionVenta $comisionVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ComisionVenta  $comisionVenta
     * @return \Illuminate\Http\Response
     */
    public function edit(ComisionVenta $comisionVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ComisionVenta  $comisionVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComisionVenta $comisionVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ComisionVenta  $comisionVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComisionVenta $comisionVenta)
    {
        //
    }
}
