<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVenta extends Model
{
    protected $table="tipos_ventas";
    protected $fillable=['descripcion'];

    public function ventas(){
        return $this->hasMany('App\Venta','tipos_ventas');
    }
}
