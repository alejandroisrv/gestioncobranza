<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CobroJornada extends Model
{

    protected $table = 'cobros_jornada';
    public function cliente(){
        return $this->hasManyThrough('App\Cliente','App\RutaItem');
    }
    public function acuerdo_pago(Request $request){
        return $this->belognsTo('App\AcuerdoPago');
    }
}
