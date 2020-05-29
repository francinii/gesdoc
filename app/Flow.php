<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    /**
     * An user belongs (or  own) to many flows 
    */
    public function user() {
        return $this->belongsTo('App\User','id');
    }

    /**
     * A flow has some documents
    */
    public function documents() { 
        return $this->hasMany('App\Document');
    }    

    /**
     * A flow has some steps
    */
    public function steps() {
        return $this->hasMany('App\Step');
    }
    
}
