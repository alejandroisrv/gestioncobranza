<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcuerdoPago extends Model
{
        protected $table="acuerdos_pagos";
        protected $fillable=['cuotas','periodo_pago'];

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