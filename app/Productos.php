<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{

    protected $table = "productos";    
    protected $fillable=['nombre','descripcion','precio_costo','precio_contado','precio_credito','comision','cantidad',];


    public function bodega(){
        
        return $this->belongsTo('App\Bodega');

    }
    public function sucursal(){
        
        return $this->belongsTo('App\Sucursal');

    }
}
