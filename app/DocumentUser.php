<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentUser extends Model
{
    /**
     * Relación de muchos a muchos
    */
    public function accions() {
        return $this->belongsToMany('App\Accion');
    }
}
