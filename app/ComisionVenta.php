<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComisionVenta extends Model
{
    protected $table = 'comisiones';

    protected $fillable=['item_id','user_id','monto','tipo','estado'];

    public function usuario() {
        return $this->belongsTo('App\User','user_id','id');
    }

}
