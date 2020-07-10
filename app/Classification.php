<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    /*
    * An user belongs (or  own) to many documento 
    */
    public function documents() {
        return $this->belongsToMany('App\Document');
    }

    /*
    * An user belongs (or  own) to user
    */
    public function owner() {
        return $this->belongsTo('App\User','username','username');
    }


    
}
