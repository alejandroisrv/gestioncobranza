<?php

namespace App\Http\Controllers;

use App\Venta;
use App\Productos;
use App\ProductosVenta;
use App\Movimiento;
use App\ComisionVenta;
use App\AcuerdoPago;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function get(Request $request){
        $data = $request->all();
        $modulo = $data['modulo'];
        $tipo  = isset($data['tipo']) ? $data['tipo'] : null;
        $desde = isset($data['desde']) ? $data['desde'] : null ;
        $hasta = isset($data['hasta']) ? $data['hasta'] : null ;

        if($desde != null) {
            $desde = explode('/', $desde);
            $desde = $desde[2].'-'.$desde[1].'-'.$desde[0];
        }

        if($hasta != null) {
            $hasta = explode('/', $hasta);
            $hasta = $hasta[2].'-'.$hasta[1].'-'.$hasta[0];
        }
        


        if($modulo == 'mv'){
            
            $datos = Movimiento::with('producto')->where('operacion',$tipo)->whereDate('created_at','>=',$desde)->whereDate('created_at','<=',$hasta)->orderBy('created_at','DESC')->get();
            $datos->map(function ($i){
                $i['label'] = ($i['operacion']==1) ? 'Entrada' : 'Salida' ;
                $fecha = new \DateTime($i['created_at']);
                $i['fecha'] = $fecha->format('d/m/Y');
            });
            
            $fields = [
                'Producto'=>'producto.nombre',
                'Cantidad' => 'cantidad',
                'Descripcion' => 'descripcion',
                'Operacion' => 'label',
                'Fecha' => 'fecha',
            ];
            $tipoMovimiento = ($tipo == 1 ) ? 'entradas' : 'salidas' ;
            $filename = "Movimientos de {$tipoMovimiento}";
            
        }else if ($modulo == 'ac') {

            $datos = AcuerdoPago::with(['cliente'])->whereDate('created_at','>=',$desde)->whereDate('created_at','<=',$hasta)->orderBy('created_at','DESC')->get();
            $datos->map(function ($i){
                $fecha = new \DateTime($i['created_at']);
                $i['fecha'] = $fecha->format('d/m/Y');
                $i['nombre'] = $i['cliente']['nombre']." ".$i['cliente']['apellido'];
            });
            $fields = [
                'Cliente'=>'nombre',
                'Cuotas' => 'cuotas',
                'Periodo de pago' => 'periodo_pago',
                'Monto' => 'monto',
                'Estado' => 'estado',
                'Fecha' => 'fecha',
            ];

            $filename = "Acuerdos de pago";
            
        }else if ($modulo == 'cm') {
            $datos = ComisionVenta::with('usuario')->where('estado',$tipo)->whereDate('created_at','>=',$desde)->whereDate('created_at','<=',$hasta)->orderBy('created_at','DESC')->get();
            $datos->map(function ($i){
                $i['clase'] = ($i['tipo']==1) ? 'Venta' : 'Cobranza';
                $fecha = new \DateTime($i['created_at']);
                $i['fecha'] = $fecha->format('d/m/Y');
            });
            $fields = [
                'Empleado'=>'usuario.name',
                'Tipo' => 'clase',
                'Monto' => 'monto',
                'Estado' => 'estado',
                'Fecha' => 'fecha',
            ];

            $filename = "Comisiones ";
            
        }else if ($modulo == 'ls') {
            
            if($tipo == 1 ){
                $datos = Productos::all();
                $fields = [
                    'Nombre'=>'nombre',
                    'Cantidad' => 'cantidad',
                    'Comision' =>'comision',
                    'Precio de contado' => 'precio_credito',
                    'Precio a credito' => 'precio_contado',
                ];
                $filename = 'Listado de productos simple';
            }else{
                $datos = ProductosVenta::whereDate('created_at','>=',$desde)->whereDate('created_at','<=',$hasta)->orderBy('created_at','DESC')->get();
                $datos->map(function ($i){
                    $fecha = new \DateTime($i['created_at']);
                    $i['fecha'] = $fecha->format('d/m/Y');
                });

                $fields = [
                    'Nombre'=>'producto',
                    'Cantidad' => 'cantidad',
                    'Fecha' => 'fecha'
                ];
                $filename = 'Listado de productos vendidos';
            }

        }else if ($modulo == 'vn') {
            $datos = Venta::with('tipos_ventas','vendedor','persona')
            ->whereDate('created_at','>=',$desde)
            ->whereDate('created_at','<=',$hasta)
            ->orderBy('created_at','DESC')
            ->get();
            $datos->map(function ($i){
                $i['cliente'] = $i['cliente']['nombre']." ".$i['cliente']['apellido'];
                $fecha = new \DateTime($i['created_at']);
                $i['fecha'] = $fecha->format('d/m/Y');
            });

            $fields = [
                'Cliente'=>'cliente',
                'Vendedor' => 'vendedor.name',
                'Tipo' => 'tipos_ventas.descripcion',
                'Abono' => 'abono',
                'Descuento' => 'descuento',
                'Total'=>   'total',
                'Fecha' => 'fecha'
            ];
            $filename = 'Listado de ventas';
        }


        return response()->json(['data'=> $datos,'fields'=>$fields,'filename'=>$filename]);
    }
}
