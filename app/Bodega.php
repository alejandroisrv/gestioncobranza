<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    protected $fillable = ['encargado_id','sucursal_id','telefono','direccion','municipio_id'];

    public function sucursal(){
        return $this->belongsTo('App\Sucursal');
    }

    public function productos(){
            return $this->hasMany('App\Productos');
    }

    public function municipio(){
        return $this->belongsTo('App\Municipio');
    }
}
