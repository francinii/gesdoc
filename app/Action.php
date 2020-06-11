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
    public function documents() {
        return $this->belongsToMany('App\Document','action_document_user','action_id','document_id');
    }
    public function users() {
        return $this->belongsToMany('App\User','action_document_user','action_id','username');
    }
    
}
