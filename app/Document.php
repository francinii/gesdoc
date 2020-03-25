<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Un documento pertenece a un flujo
    */
    public function flow() {
        return $this->belongsTo('App\Flow');
    }

    /**
     * Relación de muchos a muchos
    */
    public function users() {
        return $this->belongsToMany('App\User');
    }

}
