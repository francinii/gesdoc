<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    /*
    * An user belongs (or  own) to many flows 
    */
    public function documents() {
        return $this->belongsToMany('App\Document');
    }

    public function classifications() {
        return $this->belongsToMany('App\Classification','classification_classification','first_id','second_id');
    }
}
