<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CobroJornada extends Model
{
    public function acuerdo_pago(Request $request){
        return $this->belognsTo('App\AcuerdoPago');
    }
}
