<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    /*
    * An user belongs (or  own) to many flows 
    */
    public function documents() {
        return $this->hasMany('App\Document');
    }

    public function classifications() {
        return $this->belongsToMany('App\Classification','classification_classification','classification_first_id','classification_second_id');
    }
}
