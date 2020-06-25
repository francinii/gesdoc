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
     * A document belongs to a flow
    */
    public function state() {
        return $this->belongsTo('App\State');
    }

    /**
     * Relationship many to many 
    */
    public function users() {
        return $this->belongsToMany('App\User');
    }
    
    /**
     * Relationship many to many 
    */
    public function classfication() {
        return $this->belongsToMany('App\Classfication');
    }

    public function owner() {
        return $this->belongsTo('App\User','username','username');
    }
 
    public function accions() {
        return $this->belongsToMany('App\Action','action_document_user','document_id','action_id');
    }

}
