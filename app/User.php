<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','cedula','telefono','direccion','email', 'password','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function comisiones(){
        return $this->hasMany('App\ComisionVenta');
    }

    public function cobros(){
        return $this->hasMany('App\Cobro');
    }
}
