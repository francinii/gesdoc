<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    /**
     * Relación de muchos a muchos
    */
    public function documentoUsers() {
        return $this->belongsToMany('App\DocumentoUser');
    }
}
