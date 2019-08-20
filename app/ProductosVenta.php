<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosVenta extends Model
{
    protected $table="productos_ventas";

    protected $fillable=['venta_id','producto_id','producto','cantidad'];

    public function venta(){
        return $this->belongsTo('App\Venta');
    }
    public function productos(){

        return $this->belongsTo('App\Productos');
    }
}
