<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoUser extends Model
{
    /**
     * Relación de muchos a muchos
    */
    public function accions() {
        return $this->belongsToMany('App\Accion');
    }
}
