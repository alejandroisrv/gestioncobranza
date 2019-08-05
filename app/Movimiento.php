<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    protected $fillable = ['producto_id','user_id','cantidad','operacion','descripcion'];


    public function producto(){
        return $this->belongsTo('App\Productos','producto_id');
    }

    
}
