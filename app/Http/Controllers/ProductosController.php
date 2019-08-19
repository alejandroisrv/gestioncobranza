<?php

namespace App\Http\Controllers;

use DB;
use App\Productos;
use App\ProductosVendedores;
use App\ProductosEntregadas;
use App\User;
use Illuminate\Http\Request;

class ProductosController extends Controller
{

    public function index(Request $request)
    {
      $data = $request->all();
      $bodega = (isset($data['bodega'])) ? $data['bodega'] : null ;
      $sucursal_id = $request->user()->sucursal_id;
      $productos = Productos::with(['bodega'])->where('sucursal_id',$sucursal_id)
      ->where(function($q) use ($bodega,$request){
        if($request->user()->isAdmin()){
          return ($bodega !== null) ? $q->where('bodega_id',$bodega) : $q ;
        }else{
          return $q->where('bodega_id',$request->user()->bodega_id);
        }
      })
      ->orderBy('cantidad','DESC')
      ->paginate(30);

      return response()->json($productos);

    }

    public function getProductos(Request $request){
      $data = $request->all();
      return $request->user()->isAdmin();
      $bodega = (isset($data['bodega'])) ? $data['bodega'] : null ;
      $sucursal_id = $request->user()->sucursal_id;
      $productos = Productos::where('sucursal_id',$sucursal_id)
      ->where(function($q) use ($bodega,$request){
        if($request->user()->isAdmin()){
          return ($bodega!=null) ? $q->where('bodega_id',$bodega) : $q ;
        }else{
          return $q->where('bodega_id',$request->user()->bodega_id);
        }
      })
      ->orderBy('cantidad','DESC')
      ->paginate(30);

      return response()->json([$productos]);

    }
    public function create(Request $request)
    {
      if($request->user()->isAdminBodega()){
          $producto=new Productos($request->all());
          $producto->bodega_id=$request->user()->bodega_id;
          $producto->sucursal_id=$request->user()->sucursal_id;
          $producto->save();
          return response()->json($producto, 201);
      }

      return response()->json(['response'=>'Unauthorized'],401);

    }

    public function update(Request $request,$id)
    {
        $producto = Productos::find($id);
        $producto->update($request->all());
        return $producto;
    }
    public function abastecer(Request $request){

        $data=$request->all();
        $vendedor = auth()->user();
        for($i=0;$i<count($data);$i++){
          $idProducto=$data[$i]['producto']['id'];
          $cantidad = $data[$i]['cantidad'];
          $producto=Productos::find($idProducto);
          $producto->cantidad += $cantidad;
          $producto->save();
          $this->addHistory($idProducto,$cantidad,+1,"Abastecimiento de productos",$vendedor->id);
        }

        return response()->json(['response' => true],200);

    }
    public function entregar(Request $request){

      $datos=$request->all();
      try {
        for ($j=0; $j < count($datos['vendedores']) ; $j++) {
          $vendedor = User::find($datos['vendedores'][$j]['id']);
          $productosEntregadas=ProductosEntregadas::create([
              'vendedor_id' => $datos['vendedores'][$j]['id'],
              'bodega_id' =>  $datos['bodega']['id'],
          ]);
            for ($i=0; $i < count($datos['productosEntregar']); $i++) {
              $idProducto=$datos['productosEntregar'][$i]['producto']['id'];
              $cantidad = $datos['productosEntregar'][$i]['cantidad'];
              $productoEntregar=ProductosVendedores::create([
                'detalle' => $productosEntregadas->id,
                'producto_id' => $idProducto,
                'cantidad'=> $cantidad,
              ]);
              if($productoEntregar){
                $this->addHistory($idProducto,$cantidad,-1,"Entrega de productos a {$vendedor->name}",auth()->user()->id);
              }
           }
         }

         for ($i=0; $i < count($datos['productosEntregar']); $i++) {
           $idProducto=$datos['productosEntregar'][$i]['producto']['id'];
           $producto=Productos::find($idProducto);
           $producto->cantidad=$producto->cantidad-$datos['productosEntregar'][$i]['cantidad'];
           $producto->save();
         }
         return response()->json(['response'=> true ],201);

      } catch (\Exception $e) {
          return response()->json(['error'=> $e->getMessage()], 422);
      }


      return response()->json($is_saved);

    }
    public function destroy($id)
    {
        return Productos::destroy($id);

    }
}
