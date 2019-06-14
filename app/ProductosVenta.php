<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosVenta extends Model
{
    protected $table="productos_ventas";

    protected $fillable=['producto_id','producto','cantidad','venta_id'];

    public function venta(){
        return $this->belongsTo('App\Venta');
    }

}
