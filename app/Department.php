<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * Relationship one to many 
    */
    public function users() {
        return $this->belongsToMany('App\User');
    }
}
