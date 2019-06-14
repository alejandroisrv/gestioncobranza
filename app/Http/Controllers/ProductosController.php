<?php

namespace App\Http\Controllers;

use App\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{

    public function index()
    {   
        $sucursal=0;
        return $producto=Productos::all();
    }


    public function getProducto(Reqeuest $request,$id)
    {
        return $producto=Productos::find($id);
    }
    public function create(Request $request)
    {

        $producto=new Productos($request->all());
        $producto->bodega_id=1;
        $producto->sucursal_id=1;
        $producto->save();
        return $producto;
    }

    public function update(Request $request,$id)
    {
        $producto = Productos::find($id);
        $producto->update($request->all());
        return $producto;
    }
    public function abastecer(Request $request,$id){

        $data=$request->all();

        for($i=0;count($data['productos']);$i++){
            $producto=Producto::find($data[$i]['producto']);
            $producto->cantidad +=$data[$i]['cantidad']; 
            $producto->save();
        }

        

    }
    public function entregar(Request $request){




    }
    public function destroy($id)
    {
        return Productos::destroy($id);
        
    }
}
