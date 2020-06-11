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

    /*
    * An user belongs (or  own) to many classifications 
    */
    public function classifications() {
        return $this->belongsToMany('App\Classification','classification_classification','first_id','second_id');
    }
    /*
    * create a ob
    *
    */
    public function parentClassifications() {
        return $this->belongsToMany('App\Classification','classification_classification','second_id','first_id');
    }
    
}
