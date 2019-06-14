<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComisionVenta extends Model
{
    protected $table = 'comision_ventas';

    protected $fillable=['venta_id','venta_id','vendedor_id','monto','estado'];

    public function venta(){

        return $this->belognsTo('App\Venta');
    }
    public function vendedor(){

        return $this->belognsTo('App\User');

    }
}
