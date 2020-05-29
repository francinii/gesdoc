<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{   
    /**
     * One step belongs to a flow
    */
    public function flow() {
        return $this->belongsTo('App\Flow');
    }

    /**
     * The steps that belong to the step.
     */
    public function steps() {
        return $this->belongsToMany('App\Step');
    }


    /**
     * One step belongs to a StepUser
    */
    public function stepUser() {
        return $this->belongsTo('App\StepUser');
    }
}
