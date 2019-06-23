<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    public $fillable= ['municipio','sucursal_id'];
    public function sucursales(){
        return $this->hasMany('App\Sucursal');
    }
}
