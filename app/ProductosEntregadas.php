<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosEntregadas extends Model
{

    protected $fillable = [
        'vendedor_id',
        'bodega_id',
        'comentario',
        'estado'
    ];
}
