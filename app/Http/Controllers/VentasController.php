<?php

namespace App\Http\Controllers;
use App\Venta;
use App\TipoVenta;
use App\AcuerdoPago;
use App\ProductosVenta;
use App\ComisionVenta;
use App\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $data=$request->all();
        $limite = (isset($data['limite'])) ? $data['limite'] : 20 ;
        $sucursal=(isset($data['sucursal'])) ? $data['sucursal']: $request->user()->sucursal_id ;
        $tipoventa = (isset($data['tipoventa'])) ? $data['tipoventa'] : null ;
        $acuerdoPago = (isset($data['acuerdo_pago'])) ? $data['acuerdo_pago'] : null ;
        $cliente=(isset($data['cliente'])) ?  $data['cliente'] : null ; 
        $vendedor = (isset($data['vendedor'])) ? $data['vendedor'] : null  ;
        $desde = (isset($data['desde'])) ? $data['desde'] : null ;
        $hasta = (isset($data['hasta'])) ? $data['hasta'] : null ;
        

        $ventas = Venta::with('tipos_ventas','vendedor','acuerdo_pago','persona','productos_venta')
        ->whereHas('acuerdo_pago', function($q) use($acuerdoPago){
            return ($acuerdoPago!=null) ? $q->where('id',$acuerdoPago) : $q ; 
        })->where(function($q)use($cliente){
            return ($cliente!=null) ? $q->where('cliente_id',$cliente) : $q ; 
        })->where(function($q) use ($tipoventa){
            return ($tipoventa!=null) ? $q->where('tipo_venta',$tipoventa) : $q ;

        })->paginate($limite);

        return response()->json(['body'=>$ventas]);
    }

    public function create(Request $request)
    {

        $data=$request->all();
        $vendedor=$request->user()->id;
        $total=0;
        $venta = [
                    'cliente_id'=> $data['cliente']['id'],
                    'user_id'=>$vendedor,
                    'tipo_venta'=>$data['tipo']['id'],
                    'total'=> $total
        ];
        $venta = new Venta($venta);
        $acuerdoPago=new AcuerdoPago(['cuotas'=> $data['cuotas'], 'periodo_pago'=>$data['periodo']]);
        $venta->save();
        $acuerdoPago->venta_id=$venta->id;
        $acuerdoPago->save();
      
        for($i=0; $i<count($data['productosVendidos']);$i++){
            $data['productosVendidos'][$i]['venta_id']=$venta->id;
            $producto=Productos::findOrFail($data['productosVendidos'][$i]['producto']['id']);
            $comision=$producto->comision*$data['productosVendidos'][$i]['cantidad'];
            $precio = ($venta->id == 1 ) ? $producto->precio_costo : $producto->precio_contado ;
            $total+=$data['productosVendidos'][$i]['cantidad']*$precio;
            ComisionVenta::create(['venta_id'=> $venta->id, 'user_id'=> $vendedor, 'monto'=>$comision, 'estado'=> 'No pagada' ]);
            $productoVenta=['venta_id' => $venta->id,
                            'producto_id'=> $data['productosVendidos'][$i]['producto']['id'],
                            'producto' => $data['productosVendidos'][$i]['producto']['nombre'],
                            'cantidad'=> $data['productosVendidos'][$i]['cantidad']
                        ];
            ProductosVenta::create($productoVenta);
        }
        $venta->total=$total;
        $venta->save();
        return response()->json(['response'=>'ok','producto'=>$productoVenta]);
       
    }

    public function getTipos(Request $request){
        $tipos_ventas=TipoVenta::all();
        return response()->json(['body'=> $tipos_ventas]);
    }
}
