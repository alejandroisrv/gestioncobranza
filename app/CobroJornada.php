<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CobroJornada extends Model{

    public $timestamps = false;
    protected $table = 'cobros_jornada';
    protected $fillable = ['cobro_id', 'ruta_item_id','acuerdo_pago_id','monto','comision','estado','observacion','fecha_culminacion'];

    public function ruta_items(){
        return $this->belongsTo('App\RutaItem','ruta_item_id');
    }

    public function acuerdospagos(){
        return $this->belongsTo('App\AcuerdoPago','acuerdo_pago_id');
    }

}