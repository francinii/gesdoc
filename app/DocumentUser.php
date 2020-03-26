<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentUser extends Model
{
    /**
     * Relationship many to many 
    */
    public function accions() {
        return $this->belongsToMany('App\Accion');
    }
}
