<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $fillable = ['user_id','ruta_id','estado','comision','fecha_inicio','fecha_culminacion'];
    public function ruta () {
        return $this->belongsTo('App\Ruta');
    }

    public function cobrador () {
        return $this->belongsTo('App\User');
    }

    public function cliente(){
        return $this->hasManyThrough('App\Cliente','App\RutaItem');
    }
    public function cobros(){
        return $this->hasManyThrough('App\AcuerdoPago','App\CobroJornada');

    }
    public function items() { 
        return $this->hasMany('App\CobroJornada');
    }


}
