<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * A permission belongs to many roles
    */
    public function roles() {
        return $this->belongsToMany('App\Role');
    }
}