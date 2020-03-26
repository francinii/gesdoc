<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * A role belongs to many permissions
    */
    public function permissions() {
        return $this->belongsToMany('App\Permission');
    }

    /**
     * A role has many  users
    */
    public function users() {
        return $this->hasMany('App\User');
    }
}
