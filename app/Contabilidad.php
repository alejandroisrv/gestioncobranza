<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contabilidad extends Model
{
    public $table="contabilidad";
    protected $fillable = ['tipo','monto','descripcion','monto'];

    public function type(){
        return $this->belongsTo('App\ContabilidadCategoria','tipo');
    
    }



}
