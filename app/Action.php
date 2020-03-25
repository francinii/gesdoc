<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /**
     * Relación de muchos a muchos
    */
    public function documentUsers() {
        return $this->belongsToMany('App\DocumentUser');
    }
}
