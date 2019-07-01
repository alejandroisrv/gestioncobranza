<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComisionVenta extends Model
{
    protected $table = 'comision_ventas';

    protected $fillable=['venta_id','user_id','monto','estado'];

    public function venta() {
        return $this->belongsTo('App\Venta');
    }

    public function vendedor() {
        return $this->belongsTo('App\User');
    }

}
