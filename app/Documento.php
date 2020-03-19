<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    /**
     * Un documento pertenece a un flujo
    */
    public function flujo() {
        return $this->belongsTo('App\Flujo');
    }

    /**
     * Relación de muchos a muchos
    */
    public function users() {
        return $this->belongsToMany('App\User');
    }

}
