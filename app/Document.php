<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * A document belongs to a flow
    */
    public function flow() {
        return $this->belongsTo('App\Flow');
    }

    /**
     * Relationship many to many 
    */
    public function users() {
        return $this->belongsToMany('App\User');
    }

}
