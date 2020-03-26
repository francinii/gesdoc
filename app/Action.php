<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /**
     * Relationship many to many 
    */
    public function documentUsers() {
        return $this->belongsToMany('App\DocumentUser');
    }
}
