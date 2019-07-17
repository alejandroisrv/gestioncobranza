<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    //
    protected $cascadeDeletes = ['items'];

    protected $fillable= ['municipio_id','nombre'];
   
    public function items() { 
        return $this->hasMany('App\RutaItem');
    }

    public function municipio(){
        return $this->belongsTo('App\Municipio');
    }

    public function cliente(){
        return $this->hasManyThrough('App\Cliente','App\RutaItem');
    }

    public function cobros (){
        return $this->hasMany('App\Cobro');

    }
}
