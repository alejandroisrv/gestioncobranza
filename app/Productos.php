<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{

    protected $table = "productos";
    protected $fillable=['cod','sucursal_id','bodega_id','nombre','descripcion','tipo_id','precio_costo','precio_contado','precio_credito','comision','cantidad','imagen'];


    public function bodega(){
        return $this->belongsTo('App\Bodega');

    }
    public function sucursal(){
        return $this->belongsTo('App\Sucursal');
    }

    public function tipo(){
        return $this->belongsTo('App\TipoProducto');
    }

    public function productos_venta(){
        return $this->hasMany('App\ProductosVenta');
    }
}
