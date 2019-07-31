<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContabilidadCategoria extends Model
{
    public $table = "contabilidad_categoria";

    protected $fillable = ['descripcion','operacion'];
    public $timestamps = false;


    public function transacciones (){
        return $this->hasMany('App\Contabilidad','tipo','id');
    }

}
