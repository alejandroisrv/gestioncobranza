<?php

namespace App\Http\Controllers;

use DB;
use App\Productos;
use App\ProductosVendedores;
use App\ProductosEntregadas;
use App\User;
use Illuminate\Http\Request;
use App\TipoProducto;
class ProductosController extends Controller
{

    public function index(Request $request)
    {
      $data = $request->all();
      $bodega = (isset($data['bodega'])) ? $data['bodega'] : null ;
      $sucursal_id = $request->user()->sucursal_id;
      $buscar = (isset($data['buscar'])) ? $data['buscar'] : null ;
      $productos = Productos::with(['bodega','tipo'])->where('sucursal_id',$sucursal_id)
      ->where(function($q) use ($bodega,$request){
        if($request->user()->isAdmin()){
          return ($bodega !== null) ? $q->where('bodega_id',$bodega) : $q ;
        }else{
          return $q->where('bodega_id',$request->user()->bodega_id);
        }
      })
      ->where(function($q) use ($buscar){
          return ($buscar !== null) ? $q->where('cod','like',$buscar)->orWhere('nombre','like','%'.$buscar.'%') : $q ;
      })->orderBy('cantidad','DESC')
      ->paginate(10);

      return response()->json($productos);

    }


    public function create(Request $request){
      $data = $request->all();
      $user = $request->user();
      if($user->isAdminBodega()){

        try {

          $imagenName = null;
          if($request->hasFile('productoImagen')){
            $file = $request->file('productoImagen');
            $imagenName = time().$file->getClientOriginalName();
            $file->move(public_path('img/productos/'),$imagenName);
          }

          $producto = Productos::create([
              'bodega_id' => $user->bodega_id,
              'sucursal_id'=> $user->sucursal_id,
              'nombre' => $data['nombre'],
              'descripcion' => $data['descripcion'], 
              'tipo_id' => $data['tipo'],
              'comision' => $data['comision'],
              'precio_contado' => $data['precio_contado'],
              'precio_costo' => $data['precio_costo'],
              'precio_credito'=> $data['precio_credito'],
              'imagen' => $imagenName
          ]);

          $producto->cod = "0{$producto->tipo_id}0{$producto->id}";
          $producto->save();
  
          return response()->json([$producto],201);

          } catch (\Exception $e) {
            return response()->json(['response'=> $e->getMessage()],422);
          }

      }

      return response()->json(['response'=>'Unauthorized'],401);

    }

    public function update(Request $request,$id)
    {
        $data = $request->all();
        $producto = Productos::find($id);
        $imagenName = null;
          if($request->hasFile('productoImagen')){
            $file = $request->file('productoImagen');
            $imagenName = time().$file->getClientOriginalName();
            $file->move(public_path('img/productos/'),$imagenName);
          }
        $producto->update([
          'nombre' => $data['nombre'],
          'descripcion' => $data['descripcion'], 
          'tipo_id' => $data['tipo'],
          'comision' => $data['comision'],
          'precio_contado' => $data['precio_contado'],
          'precio_costo' => $data['precio_costo'],
          'precio_credito'=> $data['precio_credito'],
          'imagen' => $imagenName
        ]);
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


    public function getTipos(Request $request){
      $tipos = TipoProducto::withCount('productos')->paginate(10);
      $tipos->load('productos');
      return response()->json(['body' => $tipos]);
    }

    public function getTiposList(){
      $tipos = TipoProducto::all();
      return response()->json($tipos);
    }


    public function addTipo(Request $request){
      $data = $request->all();
      $tipo = TipoProducto::create([
        'label' => $data['tipo'],
        'alias' => str_slug($data['tipo']),
      ]);
      return response()->json(['response'=> true, 'item'=>$tipo],201);
    }

    
    public function editTipo(Request $request){
      $data = $request->all();
      $tipo = TipoProducto::find($data['id'])->update([
        'label' => $data['tipo'],
        'alias' => str_slug($data['tipo']),
      ]);
      return response()->json(['response'=> true, 'item'=>$tipo],201);
    }

    public function deleteTipos($id){

      $tipo= TipoProducto::find($id);

      if($tipo->delete()){
        return response()->json(['response'=> true],201);
      }

      return response()->json(['response'=> false],201);

    }

    public function destroy($id){

        try {
          $producto = Productos::find($id);
          if($producto){
              $producto->delete();
              return response()->json(['response' => true],200);
          }
        } catch (\Exception $e) {
          return response()->json(['response' => $e->getMessage()],422);
        }

        return response()->json(['response' => false],422);

    }
}
