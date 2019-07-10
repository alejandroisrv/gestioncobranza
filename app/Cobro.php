<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
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


}
