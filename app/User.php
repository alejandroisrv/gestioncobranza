<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sucursal_id',
        'bodega_id',
        'name',
        'cedula',
        'direccion',
        'telefono',
        'email',
        'correo',
        'role',
        'password',
        'api_token',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['enlazado'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ventas() {
        return $this->hasMany('App\Venta');
    }

    public function sucursal(){
        return $this->belongsTo('App\Sucursal');
    }

    public function bodega(){
        return $this->belongsTo('App\Bodega');
    }

    public function rol(){
        return $this->belongsTo('App\Role','role');
    }

    public function comisiones(){
        return $this->hasMany('App\ComisionVenta');
    }

    public function cobros(){
        return $this->hasMany('App\Cobro');
    }

    public function getEnlazadoAttribute(){

        if (!Bodega::where('encargado_id',$this->id)->exists()){
            return false;
        }

        return true;
    }

    public function isAdmin (){
        if($this->role == 1 ){
            return true;
        }
        return false;
    }

    public function isAdminBodega (){
        if($this->role == 1 || $this->role == 2){
            return true;
        }
        return false;
    }

    public function isCobrador (){
        if($this->role == 1 || $this->role == 3){
            return true;
        }
        return false;
    }

    public function isVendedor(){
        if($this->role == 1 || $this->role == 4){
            return true;
        }
        return false;
    }

}
