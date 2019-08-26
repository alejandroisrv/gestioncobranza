<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    protected $table = 'tipo_productos';
    protected $fillable= [
        'label',
        'alias'
    ];
    public $timestamps = false;
    public function productos(){
        return $this->hasMany('App\Productos','tipo_id');
    }

}
