<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contabilidad extends Model
{
    public $table="contabilidad";
    protected $fillable = ['tipo','user_id','monto','descripcion','monto'];

    public function type(){
        return $this->belongsTo('App\ContabilidadCategoria','tipo');
    }

    public function usuario(){
        return $this->belongsTo('App\User','user_id');
    }

    public function sucursal(){
        return $this->hasManyThrough('App\Sucursal','App\User','sucursal_id','user_id');
    }

}
