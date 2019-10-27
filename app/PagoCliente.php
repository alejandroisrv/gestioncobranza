<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoCliente extends Model
{
    protected $table='pagos_clientes';
    protected $fillable=['cliente_id','acuerdo_pago_id','venta_id','saldo','monto'];

    public function venta(){
        return $this->belongsTo('App\Venta');
    }

    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }

    public function acuerdos_pago(){
        return $this->belongasTo('App\AcuerdoPago');
    }
}
