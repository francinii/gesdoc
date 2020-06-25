<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * A state has some documents
    */
    public function documents() { 
        return $this->hasMany('App\Document');
    } 
}
