<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flujo extends Model
{
    /**
     * Un usuario pertenece  o es dueño de varios flujos
    */
    public function user() {
        return $this->belongsTo('App\User','id');
    }

    /**
     * Un flujo posee varios documentos
    */
    public function documento() {
        return $this->hasMany('App\Documento');
    }
}
