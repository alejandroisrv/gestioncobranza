<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RutaItem extends Model
{
    protected $fillable= ['ruta_id','cliente_id','orden'];
    public $timestamps = false;

    
    public function ruta(){
        return $this->belongsTo('App\Ruta','ruta_id');
    }

    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }
}
