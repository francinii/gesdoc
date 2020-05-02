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
        'name', 'username',  'email', 'role_id','department_id', 'password',
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


    /**
     * The user belongs to a role
    */
    public function role() {
        return $this->belongsTo('App\Role');
    }

    /**
     * The user has many flows
    */
    public function flujos() {
        return $this->hasMany('App\Flujo');
    }

    /**
     * Relationship many to many
    */
    public function documentos() {
        return $this->belongsToMany('App\Documento');
    }
}
