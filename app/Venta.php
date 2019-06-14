<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{

    protected $fillable=['cliente_id','vendedor_id','tipo_venta','total'];

    public function vendedor(){

        return $this->belongsTo('App\User');
    
    }


    public function acuerdo_pago(){
        return $this->hasOne('App\AcuerdoPago');

    }
    public function productos_venta(){

        return $this->hasOne('App\ProductosVenta');
    }
    public function tipos_ventas(){

        return $this->belongsTo('App\TipoVenta','tipo_venta','id');
    }

    public function persona(){

        return $this->belongsTo('App\Cliente','cliente_id','id');
    }
}

