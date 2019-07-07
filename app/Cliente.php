<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table="clientes";
    protected $fillable=['nombre','apellido','direccion','cedula','municipio_id','telefono','email'];
    
    public function venta() {
        return $this->hasMany('App\Venta');
    }
    public function acuerdos_pagos(){
      return $this->hasMany('App\AcuerdoPago');
    }
    public function sucursal(){
      return $this->belongsTo('App\Sucursal');
    }
    public function pagos_clientes(){
      return $this->hasMany('App\PagoCliente');
    }
    public function ruta_items(){
      return $this->hasOne('App\RutaItem');
    }
}
