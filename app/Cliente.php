<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table="clientes";
    protected $fillable=['sucursal_id',
                          'cod',
                          'nombre',
                          'cedula',
                          'telefono',
                          'direccion',
                          'municipio_id',
                          'email',
                          'ruta'
                        ];

    public function sucursal(){
      return $this->belongsTo('App\Sucursal');
    }
    
    public function venta() {
        return $this->hasMany('App\Venta');
    }

    public function municipio(){
      return $this->belongsTo('App\Municipio');
    }

    public function acuerdos_pagos(){
      return $this->hasMany('App\AcuerdoPago');
    }

    public function pagos_clientes(){
      return $this->hasMany('App\PagoCliente');
    }
    public function ruta_items(){
      return $this->hasOne('App\RutaItem');
    }
}
