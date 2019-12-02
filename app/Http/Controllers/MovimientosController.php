<?php

namespace App\Http\Controllers;

use App\Movimiento;
use Illuminate\Http\Request;

class MovimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request){

        $data = $request->all();

        $desde = isset($data['desde']) ? $data['desde'] : null ;
        $hasta = isset($data['hasta']) ? $data['hasta'] : null ;
        $producto = isset($data['producto']) ? $data['producto'] : null ;
        $tipo = isset($data['tipo']) ? $data['tipo'] : null ;

        try {

            if($desde != null) {
                $desde = explode('/', $desde);
                $desde = $desde[2].'-'.$desde[1].'-'.$desde[0];
            }

            if($hasta != null) {
                $hasta = explode('/', $hasta);
                $hasta = $hasta[2].'-'.$hasta[1].'-'.$hasta[0];
            }

            $movimientos = Movimiento::with('producto')
            ->whereHas('producto', function($q) use($request) {
                return $q->where('bodega_id',$request->user()->bodega_id);
            })
            ->where(function($q) use($tipo) {
                return ($tipo !== null) ? $q->where('operacion',$tipo) : $q ;
            })
            ->where(function($q) use($producto) {
                return ($producto !== null) ? $q->where('producto_id',$producto) : $q ;
            })
            ->where(function($q) use($desde) {
                return ($desde !== null) ? $q->whereDate('created_at','>=',$desde) : $q ;
            })
            ->where(function($q) use($hasta) {
                return ($hasta !== null) ? $q->whereDate('created_at','<=',$hasta) : $q ;
            })
            ->paginate(25);


            return response()->json(['body'=> $movimientos],200);

        } catch (\Exception $e) {

            return response()->json(['error'=> $e->getMessage()], 422);

        }

    }


}
