<?php

namespace App\Http\Controllers;

use App\Productos;
use App\ProductosVendedores;
use App\ProductosEntregadas;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {

    }

    public function index(Request $request)
    {
      $data = $request->all();
      $sucursal_id=$request->user()->sucursal_id;
      $bodega = (isset($data['bodega'])) ? $data['bodega'] : null ;
      $productos = Productos::where('sucursal_id',$sucursal_id)->where(function($q)use($bodega){
        return ($bodega!==null) ? $q->where('bodega_id',$bodega) :$q ;
      })->paginate(30);

      return response()->json($productos);
    }


    public function getProducto(Request $request,$id)
    {
        return $producto=Productos::find($id);
    }
    public function getProductos(Request $request){
      $data = $request->all();
      $bodega = (isset($data['bodega'])) ? $data['bodega'] : null ;
      $productos = Productos::where('sucursal_id',$sucursal_id)->where(function(){
        return ($bodega!=null) ? $q->where('bodega_id',$bodega) :$q ;
      })->paginate(30);

      return response()->json([$productos]);

    }
    public function create(Request $request)
    {

        $producto=new Productos($request->all());
        $producto->bodega_id=$request->user()->bodega_id;
        $producto->sucursal_id=$request->user()->sucursal_id;
        $producto->save();
        return $producto;
    }

    public function update(Request $request,$id)
    {
        $producto = Productos::find($id);
        $producto->update($request->all());
        return $producto;
    }
    public function abastecer(Request $request){

        $data=$request->all();
        for($i=0;$i<count($data);$i++){
            $producto=Productos::find($data[$i]['producto']['id']);
            $producto->cantidad +=$data[$i]['cantidad'];
            $producto->save();
        }

        return $data;

    }
    public function entregar(Request $request){

      $datos=$request->all();

      for ($j=0; $j < count($datos['vendedores']) ; $j++) {
        $productosEntregadas= new ProductosEntregadas;
        $productosEntregadas->vendedor_id=$datos['vendedores'][$j]['id'];
        $productosEntregadas->bodega_id=$datos['bodega']['id'];
        $is_saved=$productosEntregadas->save();
          for ($i=0; $i < count($datos['productosEntregar']); $i++) {
            $idProducto=$datos['productosEntregar'][$i]['producto']['id'];
            $productoEntregar=new ProductosVendedores;
            $productoEntregar->detalle=$productosEntregadas->id;
            $productoEntregar->producto_id=$idProducto;
            $productoEntregar->cantidad=$datos['productosEntregar'][$i]['cantidad'];
            $is_savedEntregar=$productoEntregar->save();

         }
       }

       for ($i=0; $i < count($datos['productosEntregar']); $i++) {
         $idProducto=$datos['productosEntregar'][$i]['producto']['id'];
         $producto=Productos::find($idProducto);
         $producto->cantidad=$producto->cantidad-$datos['productosEntregar'][$i]['cantidad'];
         if($is_savedEntregar){$producto->save();}

       }

      return response()->json($is_saved);

    }
    public function destroy($id)
    {
        return Productos::destroy($id);

    }
}
