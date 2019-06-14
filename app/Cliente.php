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

    public function sucursal(){
      return $this->belongsTo('App\Sucursal');
    }

}
