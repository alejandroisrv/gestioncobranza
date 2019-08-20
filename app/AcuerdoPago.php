<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcuerdoPago extends Model
{
        protected $table="acuerdos_pagos";
        protected $fillable=['cliente_id','venta_id','periodo_pago','cuotas','coutas_pagadas','monto','estado','finished_at'];

        public function venta(){
                return $this->belongsTo('App\Venta');
        }

        public function productos(){
                return $this->hasMany('App\Productos');
        }

        public function cliente(){
                return $this->belongsTo('App\Cliente');
        }
}
