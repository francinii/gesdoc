<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username',  'email', 'rol_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'Cedula_verified_at' => 'datetime',
    ];


    public function rol() {
        return $this->belongsTo('App\Rol');
    }

    /**
     * El usuario tiene asociado varios flujos
    */
    public function flujos() {
        return $this->hasMany('App\Flujo');
    }

    /**
     * Para relaciones de muchos a muchosS
    */
    public function documentos() {
        return $this->belongsToMany('App\Documento');
    }
}
