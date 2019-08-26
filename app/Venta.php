<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{

    protected $fillable=['cod','cliente_id','user_id','tipo_venta','total','subtotal','abono'];

    public function vendedor(){

        return $this->belongsTo('App\User','user_id','id');
    
    }

    public function acuerdo_pago(){
        return $this->hasOne('App\AcuerdoPago');

    }

    public function productos_venta(){

        return $this->hasMany('App\ProductosVenta');
    }

    public function tipos_ventas(){

        return $this->belongsTo('App\TipoVenta','tipo_venta','id');
    }
    public function comisiones(){
        return $this->hasMany('App\ComisionVenta');
    }
    public function persona(){
        return $this->belongsTo('App\Cliente','cliente_id','id');
    }
}

