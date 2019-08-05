<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosVendedores extends Model
{
    protected $table = 'productos_vendedores';
    protected $fillable= [
        'producto_id',
        'detalle',
        'cantidad',
        'estado',
        'comentario'
    ];
}
