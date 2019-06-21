<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bodega extends Model
{   protected $table="bodegas";
    protected $fillable = ['administrador', 'direccion','municipio','telefono'];
}
