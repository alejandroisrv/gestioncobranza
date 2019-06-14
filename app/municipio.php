<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class municipio extends Model
{
    public function sucursales(){
        return $this->hasMany('App\Sucursal');
    }
}
