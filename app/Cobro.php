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
        return $this->belongsTo('App\User','user_id');
    }
    
    public function items() { 
        return $this->hasMany('App\CobroJornada');
    }


}
